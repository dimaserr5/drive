# Проект DRIVE
DRIVE - Это платформа для размещения своих файлов, в ней вы сможете загружать свои файлы, размещать их в открытый доступ а так-же группировать в папки.

Пробежимя по установке, проект рабоатет на Framework Laravel версии 9, для успешной установки вам потребуется

1) Хостинг на linux, желатьельно ubunut 20.04 или выше
2) Установленный Docker (<a href="https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04-ru">Подробнее про установку</a>)
2) Установленный Compsoer (<a href="https://losst.pro/ustanovka-composer-ubuntu-16-04">Подробнее про установку</a>)
3) Установленный git на сервере (<a href="https://losst.pro/ustanovka-git-ubuntu-16-04">Подробнее про установку</a>)

Пробежимя по командам установки

Первым делом обновим пакеты
```
apt-get update && apt-get upgrade
```

Создадим дерикторию - куда будет установлен проект, в моём случае я буду устанавливать его в дерикторию /home/site
```
cd /home
```
```
mkdir site
```
```
chmod -R 755 site
```
```
cd site
```

Загружаем наш проект через команду git clone
```
git clone https://github.com/dimaserr5/drive.git
```
```
cd drive
```

Устанавливаем nodeJS
```
curl -sL https://deb.nodesource.com/setup_14.x | sudo bash -
```
```
sudo apt -y install nodejs
```

Устанавливаем пакеты через npm
```
npm install
```

Устанавливаем пакеты composer
```
composer install --ignore-platform-reqs
```

В дополнении к Docker устанавливаем docker-compose
```
apt-get install docker-compose
```

В Docker контейнер уже входит сервер базы данных, PostgreSQL, при желании вы можете изменить базу/логин/пароль, из коробки уже настроена среда PostgreSQL с 
База: a4
Логин: a4
Пароль: a4

Настройка доступа к базе лежит по пути
docker-compose.yml

Мы будем использовать деф.настройки для подключения.

Заходим в файл .env и меняем поле "APP_URL" на своё значение (IP или домен)

Далее настраиваем проект командами
```
./vendor/bin/sail up -d
```
Дожидаемся развертки - далее выдаём права на папки
```
sudo chmod -R 777 storage/
```
```
sudo chmod -R 777 bootstrap/cache/
```

Очищаем BootStrap кеш
```
./vendor/bin/sail artisan cache:clear
```
Делаем миграцию базы
```
sudo ./vendor/bin/sail artisan migrate
```
Перезапускаем проект
```
sudo ./vendor/bin/sail down
sudo ./vendor/bin/sail ud -d
```
Для разработки - нужно использовать команду
```
npm run dev
```

Для сборки в прод - нужно использовать команду
```
npm run build
```
