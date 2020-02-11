@extends('Layout.default')

@section('content')
    <div class='project-list'>
        @foreach ($projects as $item)
            <?php $modalID = 'modal-acessos-'.$item->id ?>
            <div class='slot'>
                <div class='head' onclick="$('#{{$modalID}}').modal('show');">
                    <img class='logo' src="{{asset('/storage/projects/'.$item->icon)}}" alt="">
                    <div>{{$item->name}}</div>
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
                                    @foreach ($item->acessos as $acesso)
                                        <br>
                                        <div>
                                            <div><h4>{{$acesso->title}}</h4></div>
                                            <div>{{$acesso->address}}</div>
                                            <div>{{$acesso->user}}</div>
                                            <div>{{$acesso->password}}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary">Salvar Mudanças</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
@endsection
