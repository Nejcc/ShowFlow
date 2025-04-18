# Vue Presenter

A modern, web-based presentation tool built with Vue 3, Laravel, and Tailwind CSS. Create beautiful presentations with ease and present them directly in your browser.

## Features

- 🎨 Beautiful, responsive design
- 💻 Live code presentation
- ⌨️ Keyboard navigation
- 📺 Fullscreen mode
- 🎭 Multiple slide types and layouts
- 🚀 Built with modern tech stack
- 📱 Mobile-friendly interface
- 🎯 Slide overview with thumbnails
- 🎨 Customizable themes and animations

## Tech Stack

- [Vue 3](https://vuejs.org/) - Progressive JavaScript Framework
- [Laravel](https://laravel.com/) - PHP Framework
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS Framework
- [Pinia](https://pinia.vuejs.org/) - Intuitive State Management
- [Vite](https://vitejs.dev/) - Next Generation Frontend Tooling

## Prerequisites

- PHP 8.1 or higher
- Node.js 16 or higher
- Composer
- NPM or Yarn

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/vue-presenter.git
cd vue-presenter
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Build assets:
```bash
npm run build
```

## Development

Start the development server:

```bash
php artisan serve
npm run dev
```

## Creating Presentations

### Slide Types

The system supports several types of slides:

1. **Component Slides** (`type: 'component'`)
   - Uses Vue components for complex layouts
   - Located in `resources/js/slides/pages/`
   - Named numerically (1.vue, 2.vue, etc.)

2. **Text Slides** (`type: 'text'`)
   - Simple text-based slides
   - Content is displayed line by line with animations

3. **HTML Slides** (`type: 'html'`)
   - Custom HTML content
   - Supports inline styling and custom elements

### Layouts

Available layouts in `resources/js/layouts/`:

1. **BaseLayout** - Basic layout with title and content
2. **CenteredLayout** - Centered content with title
3. **SplitLayout** - Two-column layout
4. **GridLayout** - Grid-based layout
5. **TimelineLayout** - Timeline-based layout

### Creating a New Slide

1. **Component Slide**:
```bash
# Create a new slide component
touch resources/js/slides/pages/5.vue
```

Example component slide:
```vue
<template>
  <CenteredLayout
    title="My New Slide"
    background="bg-gradient-to-r from-blue-500 to-purple-600"
    text-color="text-white"
  >
    <div class="text-xl">
      Your content here
    </div>
  </CenteredLayout>
</template>

<script setup>
import CenteredLayout from '../../layouts/CenteredLayout.vue';
</script>
```

2. **Database Entry**:
Add the slide to the database using the seeder or manually:

```php
// In database/seeders/SlideSeeder.php
$slides[] = [
    'title' => 'My New Slide',
    'type' => 'component',
    'page' => 5,
    'background' => 'bg-gradient-to-r from-blue-500 to-purple-600',
    'text_color' => 'text-white',
    'order' => 4,
];
```

### Customizing Slides

1. **Backgrounds**:
   - Use Tailwind CSS classes
   - Gradient backgrounds: `bg-gradient-to-r from-color-500 to-color-600`
   - Solid colors: `bg-blue-500`
   - Images: `bg-[url('/path/to/image.jpg')]`

2. **Text Colors**:
   - Light text: `text-white`
   - Dark text: `text-gray-900`
   - Custom colors: `text-[#hex]`

3. **Animations**:
   - Built-in animations in `resources/css/animations.css`
   - Custom animations can be added to the CSS file

## Navigation

### Keyboard Controls

- `←` Previous slide
- `→` Next slide
- `f` Toggle fullscreen
- `o` Toggle slide overview
- `Esc` Exit fullscreen/overview

### Mouse Controls

- Click navigation arrows
- Click slide numbers
- Click fullscreen button
- Click overview button
- Click thumbnails in overview

## Deployment

1. Build production assets:
```bash
npm run build
```

2. Configure your web server to point to the `public` directory

3. Set up proper environment variables in `.env`

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
