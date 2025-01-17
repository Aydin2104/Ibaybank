const express = require("express");
const fs = require("fs");
const path = require("path");
const bodyParser = require("body-parser");

const app = express();
const PORT = 3000;
const ACCOUNTS_DIR = path.join(__dirname, "Accounts");

// Настройка сервера
app.use(express.static(__dirname)); // Для раздачи HTML и статических файлов
app.use(bodyParser.urlencoded({ extended: true }));

// Обработчик формы
app.post("/login", (req, res) => {
    const username = req.body.username;
    const password = req.body.password;

    // Путь к файлу пользователя
    const accountFile = path.join(ACCOUNTS_DIR, `${username}.txt`);

    // Проверка существования файла
    if (!fs.existsSync(accountFile)) {
        return res.status(404).send("Аккаунт не найден.");
    }

    // Чтение файла и проверка данных
    const accountData = fs.readFileSync(accountFile, "utf-8").split("\n").map(line => line.trim());
    const [name, surname, phone, cardNumber, cardPassword, cardType, blockStatus] = accountData;

    if (password !== cardPassword) {
        return res.status(401).send("Неверный пароль карты.");
    }

    if (blockStatus === "1") {
        return res.status(403).send("Карта заблокирована.");
    }

    // Успешный вход
    res.send(`Добро пожаловать, ${name} ${surname}!`);
});

// Запуск сервера
app.listen(PORT, () => {
    console.log(`Сервер запущен на http://localhost:${PORT}`);
});