class Notification{

    success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Done successfully!',
            timeout: 1000,
        }).show();
    }

    alert(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'Are you sure?',
            timeout: 1000,
        }).show();
    }

    error(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Something went wrong!',
            timeout: 1000,
        }).show();
    }

    warning(){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Oops!',
            timeout: 1000,
        }).show();
    }

    image_validation(){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Image size must be less than 1 MB',
            timeout: 1000,
        }).show();
    }

    cart_success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Added to cart successfully!',
            timeout: 1000,
        }).show();
    }

    cart_delete(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Removed from cart successfully!',
            timeout: 1000,
        }).show();
    }
}

export default Notification = new Notification();
