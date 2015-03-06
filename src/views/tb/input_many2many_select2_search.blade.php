
<input class="select2-enabled" type="hidden" id="{{$name}}{{$postfix}}" name="{{$name}}" style="width:100%;">

<script>
jQuery(document).ready(function() {
    var $select2{{$name}}{{$postfix}} = jQuery('#{{$name}}{{$postfix}}').select2({
        placeholder: "{{ $search['placeholder'] or 'Поиск' }}",
        minimumInputLength: {{ $search['minimum_length'] or '3' }},
        multiple: true,
        ajax: {
            url: TableBuilder.options.action_url,
            dataType: 'json',
            type: 'POST',
            quietMillis: {{ $search['quiet_millis'] or '350' }},
            data: function (term, page) { // page is the one-based page number tracked by Select2
                return {
                    q: term, //search term
                    limit: {{ $search['per_page'] or '20' }}, // page size
                    page: page, // page number
                    ident: '{{ $name }}',
                    query_type: 'many_to_many_ajax_search',
                };
            },
            results: function (data, page) {
                return data;
            }
        },
        formatResult: function(item) {
            return item.name;
        },
        formatSelection: function(item) {
            return item.name;
        },
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    });
    
    @if ($selected != '[]')
        $select2{{$name}}{{$postfix}}.select2("data", {{ $selected }});
    @endif
});
</script>