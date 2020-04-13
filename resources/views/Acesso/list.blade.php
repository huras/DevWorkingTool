@extends('Layout.default')

@section('content')

    <h3>Novo acesso:</h3>
    <form action="/project/{{$project->id}}/storeAcesso" method='POST' enctype="multipart/form-data">
        @csrf
        <label for="">Caminho:
            <input type="text" name='address' value='{{old('address')}}'>
            @error('address')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </label>
        <label for="">Titulo:
            <input type="text" name='title' value='{{old('title')}}'>
            @error('title')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </label>
        <label for="">Usuário:
            <input type="text" name='user' value='{{old('user')}}'>
            @error('user')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </label>
        <label for="">Senha:
            <input type="text" name='password' value='{{old('password')}}'>
            @error('password')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </label>
        
        <input type="submit" value='Adicionar'>
    </form>   

    <hr>
    <div class='acesso-list'>
        @foreach ($acessos as $acesso)
            <div class='acesso-slot'>
                <div class='w-100' style='display: flex; justify-content: center; align-items: center;'>
                    <div class='field' title='Titulo' style='display: flex; justify-content: center; align-items: center;'>
                        <h4> {{$acesso->title}} </h4>
                    </div>
                </div>
                <div class='field'>
                    <a target="_blank" href="{{$acesso->address}}">
                        Abrir acesso em outra aba
                    </a>
                </div>
                <div class='field' title='Endereço'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="at" class="svg-inline--fa fa-at fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C118.941 8 8 118.919 8 256c0 137.059 110.919 248 248 248 48.154 0 95.342-14.14 135.408-40.223 12.005-7.815 14.625-24.288 5.552-35.372l-10.177-12.433c-7.671-9.371-21.179-11.667-31.373-5.129C325.92 429.757 291.314 440 256 440c-101.458 0-184-82.542-184-184S154.542 72 256 72c100.139 0 184 57.619 184 160 0 38.786-21.093 79.742-58.17 83.693-17.349-.454-16.91-12.857-13.476-30.024l23.433-121.11C394.653 149.75 383.308 136 368.225 136h-44.981a13.518 13.518 0 0 0-13.432 11.993l-.01.092c-14.697-17.901-40.448-21.775-59.971-21.775-74.58 0-137.831 62.234-137.831 151.46 0 65.303 36.785 105.87 96 105.87 26.984 0 57.369-15.637 74.991-38.333 9.522 34.104 40.613 34.103 70.71 34.103C462.609 379.41 504 307.798 504 232 504 95.653 394.023 8 256 8zm-21.68 304.43c-22.249 0-36.07-15.623-36.07-40.771 0-44.993 30.779-72.729 58.63-72.729 22.292 0 35.601 15.241 35.601 40.77 0 45.061-33.875 72.73-58.161 72.73z"></path></svg>
                    <input value='{{$acesso->address}}' class='select-all-onfocus w-100'>
                </div>
                <div class='field' title='Usuário'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" class="svg-inline--fa fa-user fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
                    <input value='{{$acesso->user}}' class='select-all-onfocus'>
                </div>
                <div class='field' title='Senha'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="key" class="svg-inline--fa fa-key fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
                    <input value='{{$acesso->password}}' class='select-all-onfocus'>
                </div>
                <div class='field' title='Projetos'>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tag" class="svg-inline--fa fa-tag fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 252.118V48C0 21.49 21.49 0 48 0h204.118a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882L293.823 497.941c-18.745 18.745-49.137 18.745-67.882 0L14.059 286.059A48 48 0 0 1 0 252.118zM112 64c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z"></path></svg>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        window.addEventListener('load', () => {
            for (element of document.querySelectorAll('.field')){
                element.addEventListener('click',(event) => {
                    event.target.select();
                });
            }
        });
    </script>
@endsection