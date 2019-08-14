<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered @isset($addClass) {{ $addClass }} @endisset" role="document">


            @if ($form)
                <form class="modal-content"
                    @if (!empty($form['action']))
                    action="{{ $form['action'] }}"
                    @endif

                    @if (!empty($form['method']))
                    method="{{ $form['method'] }}"
                    @endif
                >
                @csrf
            @else
            <div class="modal-content">
            @endif

        <div class="modal-header">
            <h5 class="modal-title">{{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="modal-body">{{ $slot }}</div>


        @if (!empty($buttons))
        <div class="modal-footer">

            {{ $buttons }}

        </div>
        @endif


        @if ($form)
            </form>
        @else
            </div>
        @endif


    </div>
</div>
