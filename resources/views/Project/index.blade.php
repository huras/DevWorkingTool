@extends('Layout.default')

@section('content')
    <div class='project-list'>
        @foreach ($projects as $item)
            <?php $modalID = 'modal-acessos-'.$item->id ?>
            <div class='slot'>
                <div class='head' onclick="$('#{{$modalID}}').modal('show');">
                    <img class='logo' src="{{asset('/storage/projects/'.$item->icon)}}" alt="">
                    <div>{{$item->name}}</div>
                    <div class='acoes'>
                        <span class='acessos'>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="key" class="acessos svg-inline--fa fa-key fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z"></path></svg>
                        </span>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="{{$modalID}}" tabindex="-1" role="dialog" aria-labelledby="{{$modalID}}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{$modalID}}Label"> Acessos {{$item->name}} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <script>
                                        window.addEventListener('load', function(){
                                            @foreach ($item->acessos as $acesso)
                                                insertAccessSlot({{$acesso->id}}, '{{$modalID}}', '{{$acesso->title}}', '{{$acesso->address}}', '{{$acesso->user}}', '{{$acesso->password}}');
                                            @endforeach
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary">Salvar Mudanças</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function insertAccessSlot(accessID, modalID, titleContent = '[Novo acesso]', addressContent = '[Endereço]', userContent = '[Usuário]', passwordContent = '[Senha]'){
                        let accessSlot = document.createElement('div');
                        accessSlot.classList.add('access-slot');

                        // Title
                        let title = document.createElement('input');
                        title.classList.add('title');
                        title.value = titleContent;
                        accessSlot.appendChild(title);

                        let addressWrapper = document.createElement('div');
                        let address = document.createElement('input');
                            address.value = addressContent;
                        let addressTitle = document.createElement('div');
                            addressTitle.innerHTML = 'Endereço: ';
                        addressWrapper.appendChild(addressTitle);
                        addressWrapper.appendChild(address);
                        accessSlot.appendChild(addressWrapper);

                        let user = document.createElement('input');
                        user.value = userContent;

                        let password = document.createElement('input');
                        password.value = passwordContent;



                        accessSlot.appendChild(user);
                        accessSlot.appendChild(password);

                        let modalBody = document.querySelector('#'+modalID+' .modal-body');
                        modalBody.appendChild(accessSlot);
                    }
                </script>

            </div>
        @endforeach
    </div>
@endsection
