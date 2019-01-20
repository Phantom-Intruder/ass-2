<script id="registerForm" type="text/html">
    <form>
        <h3>Register</h3>

        <h5>Your Login data:</h5>
        <div data-fields="firstName,username,password,enterPasswordAgain"></div>

        <h5>About your new list:</h5>
        <div data-fields="listName,description"></div>

        <input type="submit" class="btn btn-info submit" />
    </form>
</script>

<script>
    $(function() {

        var UserWishList = Backbone.Model.extend({
            schema: {
                firstName: {
                    validators: ['required']
                },
                username: {
                    validators: ['required']
                },
                password: {
                    type: 'Password',
                    validators: ['required']
                },
                enterPasswordAgain: {
                    type: 'Password',
                    validators: [
                        'required',
                        { type: 'match', field: 'password', message: 'Passwords need to match!' }
                    ]
                },
                listName: {
                    validators: ['required']
                },
                description: {
                    validators: ['required']
                },
            },
        });

        var userWishList = new UserWishList({
            firstName: '',
            username: '',
            password: '',
            enterPasswordAgain: '',
            listName: '',
            description: ''
        });

        var RegisterForm = new Backbone.Form({
            model: userWishList,
            template: _.template($('#registerForm').html()),
        }).render();

        $('body').append(RegisterForm.el);

        //Run validation before submitting
        RegisterForm.on('submit', function(event) {
            var errs = RegisterForm.validate();

            if (errs) event.preventDefault();
        });

    });
</script>