$(document).ready(function() {
    /**
     * CUSTOM JQUERY VALIDATORS
     */
    $.validator.addMethod("user_names", function(value, element) {
        return this.optional(element) || /^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/.test(value);
    }, "Please specify the correct first/last name");

    $.validator.addMethod("only_spaces", function(value, element) {
        return this.optional(element) || /.*[^ ].*/.test(value);
    }, "Please specify not only spaces");

    $('#createForm').validate({
        rules: {
            "form[fname]": {
                required: true,
                user_names: true
            },
            "form[lname]": {
                required: true,
                user_names: true
            },
            "form[email]": {
                email: true
            }
        }
    });

    $('#mailForm').validate({
        rules: {
            "form[topic]": {
                required: true,
                minlength: 1,
                maxlength: 20,
                only_spaces: true
            },
            "form[body]": {
                required: true,
                minlength: 1,
                maxlength: 160,
                only_spaces: true
            }
        }
    });
});
