<x-app-layout>
    <!-- Modal -->
    <div class="modal fade" id="addfilebutton" tabindex="-1" aria-labelledby="addfilebuttonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addfilebuttonLabel">Зашрузка файла</h5>
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
                    <button type="button" onclick="addfile();" class="btn btn-primary">Загрузить</button>
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
                        <button onclick="addfolder();" style="margin: 6px;" class="btn btn-secondary">Создать папку</button>
                    </div>
                    Файлов нет
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
                        }

                        if(msg.status == "ok"){
                            const notyf = new Notyf();
                            notyf.success(msg.text);
                        }
                    }
                });
            }
        };
    </script>
</x-app-layout>
