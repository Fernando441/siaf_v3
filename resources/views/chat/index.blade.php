@extends('layouts.app')
@section('title')
    Chat
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/chat/Index.js') }}" type="text/javascript"></script>
    <script>
        $("#createConversation").on("click", function(e) {
            e.preventDefault();
            var form = $("#form_chat");
            var chatname = $("#chat_name").val();
            var to_user = $("#user_select").val();

            if (chatname == "" || to_user == "" || to_user == null || to_user == 0) {
                swal.fire({
                    title: "Error",
                    text: "Debe ingresar un nombre y seleccionar un usuario",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, lo tengo!",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                });
                return false;
            }

            form.submit();
        });
    </script>
@endpush

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Chat-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-350px w-xl-400px" id="kt_chat_aside">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="flex">
                                <div class="flex-grow-1">
                                    <div class="alert alert-custom alert-notice alert-light-primary fade show" role="alert">
                                        <div class="alert-icon"><i class="flaticon-info"></i></div>
                                        <div class="alert-text">Las conversaciones serán de conocimiento general y abierto a todos los usuarios.</div>
                                        <div class="alert-close">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="button"
                                        class="btn btn-block btn-primary font-weight-bolder text-uppercase py-4"
                                        data-toggle="modal" data-target="#kt_chat_modal"><i
                                            class="flaticon2-chat-1 mr-2"></i> Nueva conversación</button>
                                </div>
                            </div>
                            <!--begin:Users-->
                            <div class="mt-7 scroll scroll-pull">
                                <!--begin:User-->
                                <div class="align-items-center">
                                    
                                        @if ($conversations->count() > 0)
                                            @foreach ($conversations as $conversation)
                                                @php
                                                    $avatar = Auth::user()->id == $conversation->user1_id ? $conversation->user2->avatar : $conversation->user1->avatar;
                                                    $name = Auth::user()->id == $conversation->user1_id ? $conversation->user2->name : $conversation->user1->name;
                                                @endphp

                                                @component('components.conversations-list', [
                                                    'avatar' => $avatar,
                                                    'name' => $name,
                                                    'subtext' => $conversation->name,
                                                    'conversationId' => $conversation->id,
                                                ])
                                                @endcomponent
                                            @endforeach
                                        @endif
                                    
                                </div>
                                <!--end:User-->
                            </div>
                            <!--end:Users-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8" id="kt_chat_content">
                    <!--begin::Card-->
                    <div class="card card-custom h-100">
                        <!--begin::Header-->
                        <div class="card-header align-items-center px-4 py-3">
                            <div class="text-left flex-grow-1">
                                <!--begin::Aside Mobile Toggle-->
                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md d-lg-none"
                                    id="kt_app_chat_toggle">
                                    <span class="svg-icon svg-icon-lg">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Adress-book2.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </button>
                                <!--end::Aside Mobile Toggle-->

                            </div>
                            <div class="text-center flex-grow-1">
                                <div class="text-dark-75 font-weight-bold font-size-h5">Chat</div>
                            </div>
                            <div class="text-right flex-grow-1">

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->

                        <!-- center all ways with grid -->
                        <div class="card-body chat-content"
                            style="padding: 0rem 2.25rem; !important; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <!--begin::Scroll-->
                            {{-- center content all with grid --}}
                            <div style="display: grid;">
                                <!--begin::Messages-->
                                <div class="messages">
                                    <div class="msg-inicio-chat">
                                        <div class="text-center">
                                            <i class="flaticon2-chat-1" style="font-size: 5rem; color: #2b2b2b2d;"></i>
                                        </div>
                                        <p class="text-center"
                                            style="font-size: 1.5rem; color: #2b2b2b2d; font-weight: 500;">
                                            Crea un nuevo chat o selecciona uno de los chats anteriores para continuar.
                                        </p>
                                    </div>
                                </div>
                                <!--end::Messages-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer align-items-center">
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Chat-->
        </div>
        <!--end::Container-->
    </div>

    <!-- Modal-->
    <div class="modal fade" id="kt_chat_modal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="flaticon2-chat-1 mr-2"></i>Nueva conversación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('chat.create') }}" method="POST" id="form_chat">
                        @csrf
                        <div class="form-group">
                            <label for="chat_name" class="form-control-label">Nombre del chat:</label>
                            <input class="form-control" id="chat_name" type="text" name="chat_name"
                                placeholder="Escribe el nombre del chat" required />
                        </div>
                        {{-- select2 from users --}}
                        <div class="form-group">
                            <label for="user_select" style="display: block;">Selecciona un usuario</label>
                            <select class="form-control" id="user_select" name="user_select" required>
                                <option value="0">Selecciona un usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="createConversation" class="btn btn-primary font-weight-bold">Crear conversación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
