<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImportBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:import {--json= : Path to blogs JSON file} {--images= : Path to folder containing blog images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import blogs from a JSON file and copy images to public folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonPath = $this->option('json');
        $imagesPath = $this->option('images');

        if (!$jsonPath || !File::exists($jsonPath)) {
            $this->error("JSON file path is required and must exist.");
            return 1;
        }

        if (!$imagesPath || !File::isDirectory($imagesPath)) {
            $this->warn("Images folder path is missing or not a directory. Images will not be imported.");
        }

        $jsonContent = File::get($jsonPath);
        $blogs = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Invalid JSON format: " . json_last_error_msg());
            return 1;
        }

        $this->info("Starting import of " . count($blogs) . " blogs...");

        $publicBlogsPath = public_path('assets/images/blogs');
        if (!File::exists($publicBlogsPath)) {
            File::makeDirectory($publicBlogsPath, 0755, true);
        }

        foreach ($blogs as $blogData) {
            $title = $blogData['title'] ?? 'Untitled Blog';
            $this->line("Importing: <info>{$title}</info>");

            $slug = Str::slug($title);
            
            // Handle image
            $finalImagePath = null;
            if ($imagesPath && isset($blogData['image'])) {
                $sourceImage = rtrim($imagesPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $blogData['image'];
                if (File::exists($sourceImage)) {
                    $extension = File::extension($sourceImage);
                    $newImageName = time() . '_' . $slug . '.' . $extension;
                    File::copy($sourceImage, $publicBlogsPath . DIRECTORY_SEPARATOR . $newImageName);
                    $finalImagePath = 'blogs/' . $newImageName;
                } else {
                    $this->warn("  Image not found: {$sourceImage}");
                }
            }

            Blog::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'category' => $blogData['category'] ?? 'General',
                    'description' => $blogData['description'] ?? '',
                    'content' => $blogData['content'] ?? '',
                    'tags' => $blogData['tags'] ?? '',
                    'image' => $finalImagePath ?? ($blogData['image_path'] ?? null),
                ]
            );
        }

        $this->info("Import completed successfully!");
        return 0;
    }
}
