# Vue Presenter

A modern, web-based presentation tool built with Vue 3, Laravel, and Tailwind CSS. Create beautiful presentations with ease and present them directly in your browser.

## Features

- 🎨 Beautiful, responsive design
- 💻 Live code presentation
- ⌨️ Keyboard navigation
- 📺 Fullscreen mode
- 🎭 Multiple slide types
- 🚀 Built with modern tech stack

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

6. Build assets:
```bash
npm run build
```

## Development

Start the development server:

```bash
php artisan serve
npm run dev
```

## Usage

### Creating Slides

Slides are defined in `resources/js/stores/presentation.js`. Each slide can have the following properties:

```javascript
{
  id: Number,
  title: String,
  type: String, // 'content', 'list', 'code', 'grid', 'logos'
  content: String,
  background: String, // Tailwind CSS classes
  textColor: String // Optional text color classes
}
```

### Navigation

- **Keyboard Controls**:
  - `←` Previous slide
  - `→` Next slide
  - `f` Toggle fullscreen
  - `Esc` Exit fullscreen

- **Mouse Controls**:
  - Click the fullscreen button in the top-right corner
  - Use the page indicator in the bottom-right

## Code Style

This project uses [Laravel Pint](https://laravel.com/docs/pint) for PHP code style fixing. Run Pint to fix code style issues:

```bash
./vendor/bin/pint
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
