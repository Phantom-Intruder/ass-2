<h3 class="panel-title">Object List</h3>

<div id="object-list" class="panel-body"></div>

<script>
    var Item = Backbone.Model.extend({
        schema : {
            title: {
                type: 'Text',
                validators: ['required']
            },
            url: {
                type: 'Text',
                validators: ['required']
            },
            price: {
                type: 'Number',
                validators: ['required', 'number']
            },
            priority: {
                type: 'Select',
                options: ['Must Have', 'Would Be Nice To Have', 'If You Can']
            }
        },
        toString: function() {
            var attrs = this.attributes;
            return '<div class="container">' +
                        '<div class="row">' +
                            '<div class="col-sm">'
                            + attrs.title +
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.url +
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.price+
                            ',</div>' +
                            '<div class="col-sm">'
                            + attrs.priority+
                            '</div>' +
                        '</div>' +
                    '</div>';
        }
    });

    var Items = Backbone.Model.extend({
        url: function(){
            var urlLink = "http://localhost/Wishlist/index.php/Home/Item"
            return urlLink;
        },
        defaults : {
            item: {}
        }
    });

    var WishList = Backbone.Model.extend({
        schema: {
            items: {
                type: 'List',
                itemType: 'NestedModel',
                model: Item
            }
        }
    });

    var arrayOfItems = [];
    var items = new Items();
    var form;

    items.fetch({
        success: function () {
            for (var i = 0; i < 10; i++){
                if (items.get(''+i+'') !== undefined){
                    console.log(items.get(''+i+''));
                    arrayOfItems.push(items.get(''+i+''));
                }
            }

            var wishListModel = new WishList({
                items: arrayOfItems
            });

            Backbone.Form.editors.List.Modal.ModalAdapter = Backbone.BootstrapModal;

            form = new Backbone.Form({
                model: wishListModel,
                validate: true
            }).render();

            $('.panel-body').html(form.el);

            var listEditor = form.fields['items'].editor;

            listEditor.on('add', function(form, itemEditor) {
                var addedItems = new Items();

                var title = itemEditor.getValue().title;
                var url = itemEditor.getValue().url;
                var price = itemEditor.getValue().price;
                var priority = itemEditor.getValue().priority;
                addedItems.set({title: title, url: url, price: price, priority: priority});
                console.log(addedItems);
                addedItems.save();
            });

            listEditor.on('remove', function(form, itemEditor) {
                var removedItems = new Items();

                var id = itemEditor.getValue().id;
                removedItems.set({id: id});
                console.log(removedItems);
                removedItems.destroy();
            });
        }
    });
</script>