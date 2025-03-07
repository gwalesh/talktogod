# Talk To God

A spiritual guidance application that uses AI to provide personalized religious and spiritual guidance based on user's beliefs and preferences.

## Features

- User authentication and profiles
- Personalized spiritual guidance based on religious beliefs
- Integration with ChatGPT for intelligent responses
- Free tier with daily message limits
- Premium subscription for unlimited access
- Chat history tracking
- Responsive design with Bootstrap

## Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Node.js 16 or higher
- Composer
- OpenAI API key

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/talktogod.git
cd talktogod
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
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

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talktogod
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Add your OpenAI API key to `.env`:
```
OPENAI_API_KEY=your_openai_api_key
```

8. Run migrations:
```bash
php artisan migrate
```

9. Build assets:
```bash
npm run dev
```

10. Start the development server:
```bash
php artisan serve
```

## Usage

1. Register a new account
2. Complete your profile with religious preferences
3. Start chatting with the AI spiritual guide
4. Upgrade to premium for unlimited access

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
