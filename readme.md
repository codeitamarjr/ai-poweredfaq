# AI-Powered FAQ

A modern FAQ application built with Laravel, Livewire, Alpine.js, Tailwind CSS, and PrismPHP. Users can submit questions and receive AI-generated responses, which are stored for future reference.

## Features

- **Laravel**: Robust backend framework.
- **Livewire**: Reactive components for seamless user experience.
- **Alpine.js**: Lightweight JavaScript for interactivity.
- **Tailwind CSS**: Utility-first styling.
- **PrismPHP**: Syntax highlighting for code snippets.
- **AI Integration**: Handles user questions and stores AI-generated answers.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/ai-poweredfaq.git
    cd ai-poweredfaq
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install && npm run dev
    ```

3. Configure your `.env` file and set up your database.

4. Run migrations:
    ```bash
    php artisan migrate
    ```

5. Start the development server:
    ```bash
    php artisan serve
    ```

## Usage

- Submit your question in the interface.
- The AI processes your input and returns an answer.
- All questions and answers are stored and can be browsed later.

## License

MIT
