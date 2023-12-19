@component('mail::layout')

    <style>
        .flex {
            display: flex;
        }

        .justify-center {
            justify-content: center;
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    </style>

    {{-- Header --}}
    @slot ('header')
        @component('mail::header', ['url' => $app_url])
            <img src="{{ $app_logo }}" width="256" style="border-radius: 5px;" alt="">
        @endcomponent

        @component('mail::message')
            <div style="margin-bottom: 10px;"><strong>Olá, {{ $name }}!</strong></div>
            <p>Você solicitou {{ $credits }} créditos no Paraibike? Clique no botão para pagar agora!</p>
            @component('mail::button', ['url' => $url, 'color' => 'primary'])
                Pagar agora
            @endcomponent
            <p style="font-size: 10px; text-align: center; opacity: 0.7;">Se você não reconhece esse e-mail, favor desconsidere.</p>
        @endcomponent
    @endslot

    {{-- Footer --}}
    @slot ('footer')
        @component('mail::footer')
            <!-- footer -->
            Projeto desenvolvido no IFPB
        @endcomponent
    @endslot
@endcomponent
