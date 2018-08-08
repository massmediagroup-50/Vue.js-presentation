import notie from 'notie';

export default {
    methods: {
        messageSuccess() {
            return notie.alert({
                type: 'success',
                text: 'Saved'
            });
        },
        messageCatch(data) {
            let text = 'An error occured while saving';

            if (data.response.status === 422) {
                this.errors = data.response.data;
                text = 'Form error';
            }

            notie.alert({
                type: 'error',
                text: text
            });
        }
    }
};
