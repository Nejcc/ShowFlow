<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Presentation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExportPresentationCommand extends Command
{
    protected $signature = 'presentation:export {id? : The ID of the presentation to export}';
    protected $description = 'Export a presentation to a standalone HTML file';

    public function handle()
    {
        $id = $this->argument('id') ?? 1;
        $presentation = Presentation::with('slides')->find($id);

        if (!$presentation) {
            $this->error("Presentation with ID {$id} not found.");
            return 1;
        }

        // Get all slide components content
        $slideComponents = [];
        foreach ($presentation->slides as $slide) {
            if ($slide->type === 'component' && $slide->page) {
                $path = resource_path("js/slides/pages/{$slide->page}.vue");
                if (File::exists($path)) {
                    $content = File::get($path);
                    // Extract template content from the Vue component
                    if (preg_match('/<template>(.*?)<\/template>/s', $content, $matches)) {
                        $slideComponents[$slide->page] = trim($matches[1]);
                    }
                }
            }
        }

        // Get layout components content
        $layouts = [];
        $layoutFiles = [
            'BaseLayout' => resource_path('js/layouts/BaseLayout.vue'),
            'CenteredLayout' => resource_path('js/layouts/CenteredLayout.vue'),
            'SplitLayout' => resource_path('js/layouts/SplitLayout.vue'),
        ];
        
        foreach ($layoutFiles as $name => $path) {
            if (File::exists($path)) {
                $content = File::get($path);
                // Extract template content from the Vue component
                if (preg_match('/<template>(.*?)<\/template>/s', $content, $matches)) {
                    $layouts[$name] = trim($matches[1]);
                }
            }
        }

        // Get CSS content
        $css = [
            'app' => File::get(resource_path('css/app.css')),
            'animations' => File::get(resource_path('css/animations.css')),
        ];

        // Add Tailwind animations
        $css['animations'] .= "
            .animate-fade-up {
                animation: fade-up 0.5s ease-out forwards;
                opacity: 0;
            }
            
            .slide-fade-right-enter-active,
            .slide-fade-right-leave-active,
            .slide-fade-left-enter-active,
            .slide-fade-left-leave-active {
                transition: all 0.5s ease;
            }
            
            .slide-fade-right-enter-from {
                transform: translateX(100%);
                opacity: 0;
            }
            
            .slide-fade-right-leave-to {
                transform: translateX(-100%);
                opacity: 0;
            }
            
            .slide-fade-left-enter-from {
                transform: translateX(-100%);
                opacity: 0;
            }
            
            .slide-fade-left-leave-to {
                transform: translateX(100%);
                opacity: 0;
            }
        ";

        // Generate the HTML file
        $html = view('exports.presentation', [
            'presentation' => $presentation,
            'slideComponents' => $slideComponents,
            'layouts' => $layouts,
            'css' => $css,
        ])->render();

        // Save the file
        $filename = Str::slug($presentation->title) . '.html';
        File::put(base_path('exports/' . $filename), $html);

        $this->info("Presentation exported to exports/{$filename}");
        return 0;
    }
} 