<h3 class="panel-title">Items List</h3>

    <div id="object-list" class="panel-body"></div>

<button class="btn btn-warning" id="getLink">Get shareable link</button>
<div id="shareable-link"></div>

<!--php echo "<h5>Shareable link:</h5><a target='_blank' href= '". base_url()."index.php/Home/list_view/".html_escape($wishListId). "'>". base_url().'index.php/Home/list_view/'.html_escape($wishListId). "</a>"; ?>-->
<script>
    var ShareableLink = Backbone.Model.extend({
        url: "<?= base_url().'index.php/Home/link'; ?>",
        defaults: {
            link: ""
        },
        toString: function() {
            var attrs = this.attributes;
            return attrs.link;
        }
    });

    var Item = Backbone.Model.extend({
        url: "<?= base_url().'index.php/Home/Item'; ?>",
        schema : {
            id: {
              type: 'Hidden'
            },
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
        defaults: {
            id: "",
            title: "",
            url : "",
            price: 0,
            priority: "Must Have"
        },
        toString: function() {
            var attrs = this.attributes;
            return '<br/><div style="border:1px solid black" class="container">' +
                        '<div class="row" style="margin-left: 8px ">' +
                            '<div class="col-sm"><strong> Title: </strong>'
                            + attrs.title +
                            '</div>' +
                            '<div class="col-sm"><strong> URL: </strong>'
                            + attrs.url +
                            '</div>' +
                            '<div class="col-sm"><strong> Price: </strong>'
                            + attrs.price+
                            '</div>' +
                            '<div class="col-sm"><strong> Priority: </strong>'
                            + attrs.priority+
                            '</div>' +
                        '</div>' +
                    '</div>';
        }
    });

    var Items = Backbone.Model.extend({
        url: "<?= base_url().'index.php/Home/Items'; ?>",
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

    var mustHaves = [];
    var wouldLike = [];
    var ifCan = [];

    var items = new Items();
    var form;

    items.fetch({
        success: function () {
            for (var i = 0; i < 100; i++){
                if (items.get(''+i+'') !== undefined){
                    //console.log(items.get(''+i+''));
                    if (items.get(''+i+'').priority === 'Must Have'){
                        mustHaves.push(items.get(''+i+''));
                    }else if (items.get(''+i+'').priority === 'Would Be Nice To Have'){
                        wouldLike.push(items.get(''+i+''));
                    }else{
                        ifCan.push(items.get(''+i+''));
                    }
                    //console.log(mustHaves, wouldLike, ifCan);
                }
            }

            function renderViewModel(mustHaves, wouldLike, ifCan) {
                var arrayOfItems = [];

                console.log("must", mustHaves, "would", wouldLike, "if", ifCan);
                arrayOfItems = mustHaves.concat(wouldLike).concat(ifCan);

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
                    var addedItem = new Item();
                    var title = itemEditor.getValue().title;
                    var url = itemEditor.getValue().url;
                    var price = itemEditor.getValue().price;
                    var priority = itemEditor.getValue().priority;
                    addedItem.set({title: title, url: url, price: price, priority: priority});
                    addedItem.save(null, {
                        type : 'POST',
                        success: function (response) {
                            if (response.get('priority') === 1){
                                mustHaves.push({
                                    id: response.get('id'),
                                    title: response.get('title'),
                                    url: response.get('url'),
                                    price: response.get('price'),
                                    priority: "Must Have"
                                });
                            }else if (response.get('priority') === 2){
                                wouldLike.push({
                                    id: response.get('id'),
                                    title: response.get('title'),
                                    url: response.get('url'),
                                    price: response.get('price'),
                                    priority: "Would Be Nice To Have"
                                });
                            }else if (response.get('priority') === 3){
                                ifCan.push({
                                    id: response.get('id'),
                                    title: response.get('title'),
                                    url: response.get('url'),
                                    price: response.get('price'),
                                    priority: "If You Can"
                                });
                            }
                            //console.log(mustHaves, wouldLike, ifCan);
                            renderViewModel(mustHaves, wouldLike, ifCan);
                        }
                    });
                });

                listEditor.on('remove', function(form, itemEditor) {
                    var removedItem = new Item();

                    var id = itemEditor.getValue().id;
                    removedItem.url = removedItem.url + '/' + id;
                    //console.log(removedItem);

                    removedItem.destroy({
                        success: function () {
                            //console.log(id);
                            var priority = itemEditor.getValue().priority;
                            if (priority === "Must Have"){
                                for (var i = 0; i < mustHaves.length; i++){
                                    if (mustHaves[i].id === id){
                                        mustHaves.splice(Number(i), 1);
                                    }
                                }
                            }else if (priority === "Would Be Nice To Have"){
                                for (var i = 0; i < wouldLike.length; i++){
                                    if (wouldLike[i].id === id){
                                        wouldLike.splice(Number(i), 1);
                                    }
                                }
                            }else if (priority === "If You Can"){
                                for (var i = 0; i < ifCan.length; i++){
                                    if (ifCan[i].id === id){
                                        ifCan.splice(Number(i), 1);
                                    }
                                }
                            }
                            renderViewModel(mustHaves, wouldLike, ifCan);
                        }
                    });
                });

                listEditor.on('item:change', function(form, itemEditor) {
                    var updatedItem = new Item();

                    var id = itemEditor.getValue().id;
                    var title = itemEditor.getValue().title;
                    var url = itemEditor.getValue().url;
                    var price = itemEditor.getValue().price;
                    var priority = itemEditor.getValue().priority;

                    updatedItem.set({id: id, title: title, url: url, price: price, priority: priority});
                    if ((id !== "") && (id !== undefined)){
                        console.log(id);
                        updatedItem.save(null, {
                            type : 'PUT',
                            success: function (response) {
                                if (response.priority === 1){
                                    for (var i = 0; i < mustHaves.length; i++){
                                        if (mustHaves[i].id === id){
                                            if (mustHaves[i].title !== title){
                                                mustHaves[i].title = title;
                                            }
                                            if (mustHaves[i].url !== url){
                                                mustHaves[i].url = url;
                                            }
                                            if (mustHaves[i].price !== price){
                                                mustHaves[i].price = price;
                                            }
                                            if (mustHaves[i].priority !== priority){
                                                mustHaves[i].priority = priority;
                                            }
                                        }
                                    }
                                }else if (response.priority === 2){
                                    for (var i = 0; i < wouldLike.length; i++){
                                        if (wouldLike[i].id === id){
                                            if (wouldLike[i].title !== title){
                                                wouldLike[i].title = title;
                                            }
                                            if (wouldLike[i].url !== url){
                                                wouldLike[i].url = url;
                                            }
                                            if (wouldLike[i].price !== price){
                                                wouldLike[i].price = price;
                                            }
                                            if (wouldLike[i].priority !== priority){
                                                wouldLike[i].priority = priority;
                                            }
                                        }
                                    }
                                }else if (response.priority === 3){
                                    for (var i = 0; i < ifCan.length; i++){
                                        if (ifCan[i].id === id){
                                            if (ifCan[i].title !== title){
                                                ifCan[i].title = title;
                                            }
                                            if (ifCan[i].url !== url){
                                                ifCan[i].url = url;
                                            }
                                            if (ifCan[i].price !== price){
                                                ifCan[i].price = price;
                                            }
                                            if (ifCan[i].priority !== priority){
                                                ifCan[i].priority = priority;
                                            }
                                        }
                                    }
                                }
                                //renderViewModel(mustHaves, wouldLike, ifCan);
                            }
                        });
                    }
                });
            }

            renderViewModel(mustHaves, wouldLike, ifCan);
        }
    });

    $('#getLink').click(function () {
        var shareableLink = new ShareableLink();
        shareableLink.fetch({
            success: function () {
            console.log(shareableLink.get('link'));
            $('#shareable-link').append("<a target='_blank' href= '" + shareableLink.get('link') + "'>" + shareableLink.get('link') + "</a>");
        }});
    });
</script>