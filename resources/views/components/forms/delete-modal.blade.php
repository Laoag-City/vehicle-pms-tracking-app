@use('Illuminate\Support\Str')

@props([
    'modalId',
    'modalHeader',
    'modalTitle',
    'url',
    'urlParam'
])

<div id="{{ $modalId }}" class="ui basic modal" x-data="{{ $modalId }}">
    <div class="ui icon header">
        <i class="remove icon"></i>
        {{ $modalHeader }} - <span x-html="dynamicHeaderValue"></span>
    </div>

    <div class="content">
        <p>{{ $modalTitle }}</p>
    </div>

    <form method="POST" class="actions" data-url="{{ $url }}" data-url-param="{{ $urlParam }}" x-bind="deleteFormBind" x-ref="deleteForm">
        @csrf
        @method('DELETE')

        <x-actions.button class="red cancel" type="submit">
            Yes
        </x-actions.button>

        <x-actions.button class="ok grey" type="button">
            No
        </x-actions.button>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('{{ $modalId }}', () => ({
                url: '',
                urlParam: '',
                currentUrl: '',
                dynamicHeaderValue: '',

                deleteFormBind: {
                    ['x-bind:action']: 'currentUrl',
                    ['x-on:{{ Str::of($modalId)->kebab() }}-clicked.window']($event) {
                        this.currentUrl = this.url.replace(this.urlParam, $event.detail.id);
                        this.dynamicHeaderValue = $event.detail.name;
                        $('#{{ $modalId }}').modal('show');
                    },
                },
                
                init(){
                    this.url = this.$refs.deleteForm.dataset.url;
                    this.urlParam = new RegExp(this.$refs.deleteForm.dataset.urlParam, 'g');
                }
            }));
        });
    </script>
@endPush