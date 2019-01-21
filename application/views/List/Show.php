<h3 class="panel-title">Object List</h3>

<div id="object-list" class="panel-body"></div>

<script>
    var itemToString, object_list_form;

    var Items = Backbone.Model.extend({
        url : function () {
            var urlLink = "http://localhost/Wishlist/index.php/Home/item"
            return urlLink;
        },
    });

    var itemsFetched = new Items({});

    Backbone.Form.editors.List.Modal.ModalAdapter = Backbone.BootstrapModal;

    itemToString = function(value) {
        var safeString = '';
        Object.keys(value).forEach(function(key) {
            safeString += key + ':' + $('<div>').html(value[key]).text() + '<br/>';
        });

        return safeString;
    };

    object_list_form = new Backbone.Form({
        initialize : function () {
            itemsFetched.fetch()
            echo itemsFetched
        },
        schema: {
            items: {
                type: 'List',
                itemType: 'Object',
                itemToString: itemToString,
                subSchema: {
                    title: {},
                    url: {},
                    price: {},
                    priority: {}
                }
            }
        },
        data: {
            items: [
                itemsFetched.get('3')
            ]
        }
    });

    $('#object-list').html(object_list_form.render().el);
</script>