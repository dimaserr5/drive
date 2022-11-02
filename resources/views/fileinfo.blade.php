<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Информация о файле: {{ $file_name }}
        </h2>
    </x-slot>
    <div class="modal fade" id="editName" tabindex="-1" aria-labelledby="editNameLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNameLabel">Название файла</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="margin-left: 15px; flex-grow: 1">
                        <input id="folder_name" type="text" value="{{ $filter_fail_name }}" placeholder="Введите назание папки">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" id="loadbuttonfile" onclick="editFileName();" class="btn btn-primary">Переименовать файл</button>
                    <button type="button" id="loadbuttonfile" onclick="editFileName();" class="btn btn-primary">Открыть файл для общего доступа</button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="btn-top">
                        <a type="button" style="margin: 6px;"  href="{{ $file_storage }}" download class="btn btn-primary">Скачать файл</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editName" style="margin: 6px;" class="btn btn-secondary">Переименовать файл</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function editFileName() {
                var folder_name = document.getElementById('folder_name');

                var loadbutton = document.getElementById('loadbuttonfile');

                loadbutton.setAttribute('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    url: '{{route('editfilename')}}',
                    data: {folder_name: folder_name.value, file_id: '{{ $file_id }}'},
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
