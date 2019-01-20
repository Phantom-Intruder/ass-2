<h3 class="panel-title">Object List</h3>

<div id="object-list" class="panel-body"></div>

<script>
    var itemToString, object_list_form;

    Backbone.Form.editors.List.Modal.ModalAdapter = Backbone.BootstrapModal;

    itemToString = function(value) {
        var safeString = '';
        Object.keys(value).forEach(function(key) {
            safeString += key + ':' + $('<div>').html(value[key]).text() + '<br/>';
        });

        return safeString;
    };

    object_list_form = new Backbone.Form({
        schema: {
            users: {
                type: 'List',
                itemType: 'Object',
                itemToString: itemToString,
                subSchema: {
                    name: {}
                }
            }
        },
        data: {
            users: [
                {
                    name: '<a href="#">malicious injection</a>'
                }
            ]
        }
    });

    $('#object-list').html(object_list_form.render().el);
</script>