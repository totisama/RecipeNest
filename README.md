<p align="center"><img src="https://raw.githubusercontent.com/totisama/RecipeNest/refs/heads/main/public/images/recipeNest-logo.webp" width="100"></p>

# Recipe Nest
Recipe platform where you can easily search for and save your favorite recipes. Explore detailed ingredients and have a step-by-step instructions to create the recipes.

## 🧱 Getting Started


Clone the repo and enter the folder

```
git clone https://github.com/totisama/RecipeNest
cd RecipeNest
```

- run `composer install`
- Create a .env for your dev environment: `cp .env.example .env` and adjust the settings (local domain, database, etc)
- Set the encryption key in the .env: `php artisan key:generate`
- if using sqlite: do execute `touch database/database.sqlite`
- and then migrate the tables: `php artisan migrate`
- and then seed date: `php artisan db:seed`.

## 🔨 Technologies
- Laravel
- PHP
- Tailwind
- JavaScript


## 🧪 Try it here

##### Web [https://recipenest.harbourspace.site](https://recipenest.harbourspace.site)

## 👥 Authors
- Rodrigo Samayoa ([@totisama](https://github.com/totisama))

## 🪪 License

This project is licensed with the [MIT license](LICENSE).
