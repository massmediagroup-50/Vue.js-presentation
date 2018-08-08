<template>
    <div class="col-md-6">
        <label for="addresses" class="h6">Addresses</label>
        <ul class="styled-list" id="addresses">
            <li class="clearfix" v-for="(address, index) in addresses" :key="index">
                {{ address.address }} <br> {{ address.city}}
                <button type="button" class="btn btn-sm btn-minimal-danger"
                        @click.stop.prevent="removeAddress(address)">
                    Remove
                </button>
            </li>
        </ul>

        <div class="form-group clearfix">
            <button class="btn btn-primary" @click.stop.prevent="openModal('address')">
                add address
            </button>
        </div>

        <Modal size="large" v-if="currentModal === 'address'" @close="closeModals()">
            <div slot="title">Add address</div>

            <div slot="body">
                <form-errors :errors="errors"/>
                <div class="form-group">
                    <label for="address_1">Adres</label>
                    <input id="address_1" name="address" type="text" class="form-control" required v-model="address.address"/>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" name="city" type="text" class="form-control" required v-model="address.city"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postcode">Postcode</label>
                            <input id="postcode" name="postcode" type="text" class="form-control" v-model="address.postcode"  />
                        </div>
                    </div>
                </div>


            </div>
            <div slot="footer">
                <button class="btn btn-default" @click.stop.prevent="closeModals()">Cancel</button>
                <button class="btn btn-primary" @click.stop.prevent="addAddress()">Save</button>
            </div>
        </Modal>
    </div>
</template>

<script>
    import notie from 'notie';
    import OpensModals from '../mixins/OpensModals';
    import NotifyHelper from '../mixins/NotifyHelper';
    import * as addressResource from '../resources/address';

    export default {
        mixins: [OpensModals, NotifyHelper],
        props: ['profile'],
        methods: {
            add() {
                addressResource
                    .add(this.address)
                    .then(() => {
                        this.messageSuccess();
                        this.closeModals();
                        this.address = {};
                    })
                    .catch((data) => {
                        this.messageCatch(data);

                        if (data.response.status !== 422) {
                            this.closeModals();
                            this.address = {};
                        }
                    })
                    .finally(() => {
                        this.$emit('change');
                    });
            },
            remove(address) {
                notie.confirm({
                    text: 'Are you sure you want to remove this address?',
                    submitCallback: () => {
                        addressResource
                            .remove(address)
                            .then(() => {
                                this.messageSuccess();
                                this.$emit('change');
                            });
                    }
                });
            },
            addAddress() {
                this.add();
            },
            removeAddress(address) {
                this.remove(address);
            },
            beforeOpenModals() {
                this.errors = [];
            }
        },
        computed: {
            addresses() {
                return this.profile.addresses;
            }
        },
        data() {
            return {
                address: {},
                errors: []
            };
        }
    };
</script>
