import Modal from '../components/Modal.vue';
export default {
    components: {
        Modal: Modal
    },
    methods: {
        openModal(modal, data) {
            this.currentModal = modal;

            if (this.beforeOpenModals) {
                this.beforeOpenModals();
            }

            if (data) {
                this.currentModalData = data;
            }
        },
        closeModals() {
            if (this.beforeCloseModals) {
                this.beforeCloseModals();
            }
            this.currentModalData = false;
            this.currentModal = false;
            if (this.afterCloseModals) {
                this.afterCloseModals();
            }
        }
    },
    data() {
        return {
            currentModal: false
        };
    }
};
