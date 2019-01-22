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
                type: 'Number',
                validators: ['required', 'number']
            }
        },
        toString: function() {
            var attrs = this.attributes;
            return attrs.title + ', ' + attrs.url + ', ' + attrs.price+ ', ' + attrs.priority;
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
                console.log('User with first name "' + itemEditor.getValue().url + '" added.');
                var postedItems = new Items();

                var title = itemEditor.getValue().title;
                var url = itemEditor.getValue().url;
                var price = itemEditor.getValue().price;
                var priority = itemEditor.getValue().priority;
                postedItems.set({title: title, url: url, price: price, priority: priority});
                console.log(postedItems);
                postedItems.save();
            })
        }
    });
</script>