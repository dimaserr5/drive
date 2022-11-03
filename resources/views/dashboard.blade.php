<x-app-layout>
    <!-- Modal -->
    <div class="modal fade" id="addfilebutton" tabindex="-1" aria-labelledby="addfilebuttonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addfilebuttonLabel">Загрузка файла</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="margin-left: 15px; flex-grow: 1">
                        <p>Выберите файл</p>
                        <input id="js-file" type="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" id="loadbuttonfile" onclick="addfile();" class="btn btn-primary">Загрузить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addfolderbutton" tabindex="-1" aria-labelledby="addfolderbuttonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addfolderbuttonLabel">Добавление папки</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="margin-left: 15px; flex-grow: 1">
                        <input id="folder_name" type="text" placeholder="Введите назание папки">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" id="loadbuttonfolder" onclick="addFolder();" class="btn btn-primary">Добавить папку</button>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои файлы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="btn-top">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addfilebutton" style="margin: 6px;" class="btn btn-primary">Загрузить файл</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addfolderbutton" style="margin: 6px;" class="btn btn-secondary">Создать папку</button>
                    </div>

                    <?php if(!$my_files) :?>
                     <div style="margin-top: 26px;">
                         <span>Файлов нет</span>
                     </div>
                    <?php else : ?>
                        <div class="files_block">
                            @foreach($my_files as $file)
                                @if($file['type'] == "folder")
                                    <div onclick="" class="file">
                                            <a href="/dashboard/{{ $file['storage'] }}"><img class="img_file" src="{{ $file['image'] }}"></a>
                                            <div style="margin: 10px;">
                                                <span>{{ $file['name'] }}</span>
                                            </div>
                                    </div>
                                @else
                                   <div class="file">
                                       <a href="/file_info/{{ $file['id'] }}"><img class="img_file" src="{{ $file['image'] }}"></a>
                                            <div style="margin: 10px;">
                                                <span>{{ $file['name'] }}</span>
                                            </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    <?php endif; ?>

                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <span>Общий размер всех файлов: {{ $all_size_file }}</span><br>
                    <span>Доступно места: {{ $access_size }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addfile() {
            if (window.FormData === undefined) {
                alert('В вашем браузере FormData не поддерживается')
            } else {
                var formData = new FormData();
                formData.append('file', $("#js-file")[0].files[0]);

                var loadbutton = document.getElementById('loadbuttonfile');

                loadbutton.setAttribute('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    url: '{{route('dashboard/add')}}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType : 'json',
                    success: function(msg){
                        if(msg.status == 'error') {
                            const notyf = new Notyf();
                            notyf.error(msg.text);
                            loadbutton.removeAttribute("disabled");
                        }

                        if(msg.status == "ok"){
                            const notyf = new Notyf();
                            notyf.success(msg.text);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            }
        };

        function addFolder() {
                var folder_name = document.getElementById('folder_name');

                var loadbutton = document.getElementById('loadbuttonfile');

                loadbutton.setAttribute('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    url: '{{route('dashboard/addfolder')}}',
                    data: {folder_name: folder_name.value},
                    dataType : 'json',
                    success: function(msg){
                        if(msg.status == 'error') {
                            const notyf = new Notyf();
                            notyf.error(msg.text);
                            loadbutton.removeAttribute("disabled");
                        }

                        if(msg.status == "ok"){
                            const notyf = new Notyf();
                            notyf.success(msg.text);
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        }
                    }
                });
        }
    </script>
</x-app-layout>
