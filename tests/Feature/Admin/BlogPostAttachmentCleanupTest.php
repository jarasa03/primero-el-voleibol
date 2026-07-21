<?php

use App\Filament\Resources\BlogPosts\Pages\EditBlogPost;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('deletes attachment files immediately through the shared helper', function (): void {
    Storage::fake('public');

    $pdfPath = 'blog/attachments/adjunto-a-eliminar.pdf';

    Storage::disk('public')->put($pdfPath, buildAttachmentTestPdf('Adjunto temporal'));

    BlogPost::deleteAttachmentFiles($pdfPath);

    expect(Storage::disk('public')->exists($pdfPath))->toBeFalse();
});

it('loads the Filament edit page with the attachment field', function (): void {
    Storage::fake('public');

    $pdfPath = 'blog/attachments/adjunto-filament.pdf';
    Storage::disk('public')->put($pdfPath, buildAttachmentTestPdf('Adjunto filament'));

    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo de prueba',
        'attachments' => [$pdfPath],
        'content' => '<p>Contenido del articulo.</p>',
    ]);

    Livewire::test(EditBlogPost::class, [
        'record' => $blogPost->getKey(),
    ])
        ->assertOk()
        ->assertFormFieldExists('attachments');
});

it('deletes a persisted attachment through the Filament file upload field', function (): void {
    Storage::fake('public');

    $pdfPath = 'blog/attachments/adjunto-guardado.pdf';
    $featuredImagePath = 'blog/featured/articulo.jpg';

    Storage::disk('public')->put($pdfPath, buildAttachmentTestPdf('Adjunto guardado'));
    Storage::disk('public')->put($featuredImagePath, 'image');

    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo con adjunto guardado',
        'attachments' => [$pdfPath],
        'content' => '<p>Contenido del articulo.</p>',
        'featured_image_path' => $featuredImagePath,
    ]);

    $fileKey = null;

    Livewire::test(EditBlogPost::class, [
        'record' => $blogPost->getKey(),
    ])
        ->call('callSchemaComponentMethod', 'form.attachments', 'getUploadedFiles')
        ->assertReturned(function (mixed $uploadedFiles) use (&$fileKey): bool {
            expect($uploadedFiles)->toBeArray()->toHaveCount(1);

            $fileKey = array_key_first($uploadedFiles);

            expect($uploadedFiles[$fileKey]['url'])->toStartWith('http');
            expect(Str::startsWith($uploadedFiles[$fileKey]['url'], ['/storage', 'storage']))->toBeFalse();

            return is_string($fileKey);
        })
        ->call('callSchemaComponentMethod', 'form.attachments', 'deleteUploadedFile', [
            'fileKey' => $fileKey,
        ])
        ->assertHasNoErrors()
        ->assertFormSet([
            'attachments' => [],
        ])
        ->tap(function () use ($pdfPath): void {
            expect(Storage::disk('public')->exists($pdfPath))->toBeTrue();
        })
        ->call('save')
        ->assertHasNoErrors();

    expect(Storage::disk('public')->exists($pdfPath))->toBeFalse();
    expect($blogPost->refresh()->attachments)->toBe([]);
});

it('serves a Filament file upload asset that removes persisted files by their internal key', function (): void {
    $fileUploadAsset = file_get_contents(public_path('js/filament/forms/components/file-upload.js'));

    expect($fileUploadAsset)
        ->toContain('this.fileKeyIndex[N]?N')
        ->toContain('source:k,options:{metadata:{url:j.url')
        ->toContain('this.fileKeyIndex[re.source]?re.source')
        ->toContain('fetch(re?.url??N');
});

it('deletes removed attachments from disk when a blog post is updated', function (): void {
    Storage::fake('public');

    $pdfPath = 'blog/attachments/adjunto-a-eliminar.pdf';
    Storage::disk('public')->put($pdfPath, buildAttachmentTestPdf('Adjunto temporal'));

    $blogPost = BlogPost::factory()->published(now()->subDay())->create([
        'title' => 'Articulo con adjunto',
        'attachments' => [$pdfPath],
        'content' => '<p>Contenido del articulo.</p>',
    ]);

    expect(Storage::disk('public')->exists($pdfPath))->toBeTrue();

    $blogPost->forceFill([
        'attachments' => [],
    ])->save();

    expect(Storage::disk('public')->exists($pdfPath))->toBeFalse();
});

function buildAttachmentTestPdf(string $text): string
{
    $escapedText = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    $contentStream = sprintf('BT /F1 18 Tf 20 100 Td (%s) Tj ET', $escapedText);

    $objects = [
        "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
        "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
        "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 200 200] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>\nendobj\n",
        sprintf("4 0 obj\n<< /Length %d >>\nstream\n%s\nendstream\nendobj\n", strlen($contentStream), $contentStream),
        "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
    ];

    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($objects as $object) {
        $offsets[] = strlen($pdf);
        $pdf .= $object;
    }

    $xrefOffset = strlen($pdf);
    $pdf .= "xref\n0 6\n";
    $pdf .= "0000000000 65535 f \n";

    for ($index = 1; $index <= 5; $index++) {
        $pdf .= sprintf("%010d 00000 n \n", $offsets[$index]);
    }

    $pdf .= "trailer\n<< /Size 6 /Root 1 0 R >>\n";
    $pdf .= "startxref\n{$xrefOffset}\n%%EOF\n";

    return $pdf;
}
