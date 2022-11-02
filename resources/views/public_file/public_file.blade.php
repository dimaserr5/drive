<html>
    <head>
      <meta charset="UTF-8">
        <title>Файл {{ $file_name }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <style>
        .parent {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            overflow: auto;
        }

        .block {
            width: 300px;
            height: 300px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -125px 0 0 -125px;
            display: flex;
            flex-direction: column;
            align-items: center;
            -webkit-box-shadow: 0px 0px 8px 0px rgba(34, 60, 80, 0.2);
            -moz-box-shadow: 0px 0px 8px 0px rgba(34, 60, 80, 0.2);
            box-shadow: 0px 0px 8px 0px rgba(34, 60, 80, 0.2);
        }
        .text_block {
            margin: 7px;
            font-family: sans-serif;
        }
    </style>
    <body>
    <div class="parent">
        <div class="block">
            <div class="text_block">
                <span>Информация</span>
            </div>
            <div class="text_block">
                <span>Название файла: {{ $file_name }}</span>
            </div>
            <div class="text_block">
                <span>Имя файла: {{ $filter_fail_name }}</span>
            </div>
            <div class="text_block">
                <span>Расширение файла: {{ $filter_fail_ext }}</span>
            </div>
            <div class="text_block">
                <span>Размер файла: {{ $file_size }}</span>
            </div>
            <div class="text_block">
                <span>Дата создания: {{ $file_date }}</span>
            </div>
            <a href="{{ $file_storage }}" download class="btn btn-primary">
                Скачать
            </a>
        </div>
    </div>
    </body>
</html>
