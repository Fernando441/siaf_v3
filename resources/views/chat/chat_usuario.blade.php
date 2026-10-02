@extends('layouts.app')
@section('title')
    Conversación con {{ $to_user->name }}
@endsection

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/socket.io.min.js') }}"></script>
    <script src="{{ asset('js/chat/Chat.js') }}"></script>
@endpush


@section('content')
<input type="hidden" id="conversationId" name="conversationId" value="{{ $conversation->id }}">
<input type="hidden" id="userId" name="userId" value="{{ Auth::user()->id }}">
<input type="hidden" id="urlSaveMessage" name="urlSaveMessage" value="{{ route('chat.send') }}">
<input type="hidden" id="avatar" name="avatar" value="{{ $my_avatar }}">
<input type="hidden" id="user_name" name="user_name" value="{{ Auth::user()->name }}">
<input type="hidden" id="avatar_url" name="avatar_url" value="{{ route('archivo.documentoAvatar', $my_avatar) }}">
<input type="hidden" id="reciver_avatar_url" name="reciver_avatar_url" value="{{ route('archivo.documentoAvatar', $reciver_avatar) }}">
<input type="hidden" id="reciver_avatar" name="reciver_avatar" value="{{ $reciver_avatar }}">
<input type="hidden" id="reciver_user_name" name="reciver_user_name" value="{{ $to_user->name }}">
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
                            {{-- Nuevo mensaje full width button --}}
                            <div class="flex">
                                <div class="flex-grow-1">
                                    <button type="button"
                                        class="btn btn-block btn-primary font-weight-bolder text-uppercase py-4"
                                        data-toggle="modal" data-target="#kt_chat_modal"><i
                                            class="flaticon2-chat-1 mr-2"></i> Nueva conversación</button>
                                </div>
                            </div>
                            <!--begin:Users-->
                            <div class="mt-7 scroll scroll-pull">
                                <div class="align-items-center">
                                @if ($conversations->count() > 0)
                                    @foreach ($conversations as $conversacion)
                                        @php
                                            $avatar = Auth::user()->id == $conversacion->user1_id ? $conversacion->user2->avatar : $conversacion->user1->avatar;
                                            $name = Auth::user()->id == $conversacion->user1_id ? $conversacion->user2->name : $conversacion->user1->name;
                                        @endphp

                                        @component('components.conversations-list', [
                                            'avatar' => $avatar,
                                            'name' => $name,
                                            'subtext' => $conversacion->name,
                                            'conversationId' => $conversacion->id,
                                        ])
                                        @endcomponent
                                    @endforeach
                                @endif
                                </div>
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
                                <div class="text-dark-75 font-weight-bold font-size-h5">{{ $to_user->name }}</span>
                                <br>
                                <small class="text-muted">{{ $conversation->name }}</small>
                                </div>
                            </div>
                            <div class="text-right flex-grow-1">

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body chat-content"
                            style="background-image: url('{{ asset('img/memphis-mini.webp') }}');padding: 0rem 2.25rem; !important">
                            <!--begin::Scroll-->
                            <div class="scroll scroll-pull" data-mobile-height="400">
                                <!--begin::Messages-->
                                <div class="messages" id="messages">
                                    @if ($messages->count() > 0)
                                        @foreach ($messages as $message)
                                            @if ($message->user_id == Auth::user()->id)
                                                @component('components.message', [
                                                    'message' => $message->message,
                                                    'avatar' => Auth::user()->avatar,
                                                    'name' => Auth::user()->name,
                                                    'time' => $message->created_at->diffForHumans(),
                                                    'position' => 'right',
                                                ])
                                                @endcomponent
                                            @else
                                                @component('components.message', [
                                                    'message' => $message->message,
                                                    'avatar' => $to_user->avatar,
                                                    'name' => $to_user->name,
                                                    'time' => $message->created_at->diffForHumans(),
                                                    'position' => 'left',
                                                ])
                                                @endcomponent
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!--end::Messages-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer align-items-center">
                            <!--begin::Compose-->
                            <textarea id="messageInput" class="form-control border-0 p-0" rows="2" placeholder="Escribe un mensaje"></textarea>
                            <div class="d-flex align-items-center justify-content-between mt-5">
                                <div class="mr-3">

                                </div>
                                <div>
                                    <button type="button" id="sendMessageButton"
                                        class="btn btn-primary btn-md text-uppercase font-weight-bold chat-send py-2 px-6">
                                        Enviar</button>
                                </div>
                            </div>
                            <!--begin::Compose-->
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
                                data-dismiss="modal"><i class="la la-times"></i>Cancelar</button>
                            <button type="submit" id="createConversation" class="btn btn-primary font-weight-bold"><i class="la la-arrow-left"></i>Crear conversación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
