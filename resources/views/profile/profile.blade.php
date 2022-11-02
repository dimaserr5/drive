<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мой профиль
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   Информация о профиле
                    <div style="margin-top: 20px;">
                        <span>Имя: {{ $user_name }}</span>
                    </div>
                    <div style="margin-top: 20px;">
                        <span>Почта: {{ $user_email }}</span>
                    </div>
                    <div style="margin-top: 20px;">
                        <span>Дата создания: {{ $user_date_reg }}</span>
                    </div>
                    @if($api_key)
                        <div style="margin-top: 20px;">
                            <span>Api ключ: {{ $api_key }}</span>
                        </div>
                    @else
                        <div style="margin-top: 20px;">
                            <span>Api ключ: <button onclick="generateApi();" class="btn btn-primary">Создать</button></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function generateApi() {

            $.ajax({
                type: "POST",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                url: '{{route('profilegetapi')}}',
                data: {gen: 1},
                dataType : 'json',
                success: function(msg){
                    if(msg.status == 'error') {
                        const notyf = new Notyf();
                        notyf.error(msg.text);
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
