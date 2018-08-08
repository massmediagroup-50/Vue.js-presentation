<template>
    <div>
    <div class="card-body">
        <div class="card-block">

            <h4>Personal info</h4>

            <form-errors :errors="errors"/>

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" v-model="profile.user.name" />
            </div>

            <div class="form-group">
                <label for="userEmail">Email</label>
                <input class="form-control" type="text" name="email" id="userEmail" v-model="profile.user.email" />
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input class="form-control" type="text" name="slug" id="slug" v-model="profile.slug"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password (change if you wish)</label>
                        <input class="form-control" type="password" name="password" id="password" v-model="profile.user.password"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-block">
            <h4>Public profile info</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contactsEmail">Email</label>
                        <input class="form-control" type="email" name="contactsEmail" id="contactsEmail" v-model="contacts.email" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contactsPhone">Phone</label>
                        <input class="form-control" type="text" name="contactsPhone" id="contactsPhone" v-model="contacts.phone" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contactsWebsite">Website</label>
                        <input class="form-control" type="text" name="contactsWebsite" id="contactsWebsite" v-model="contacts.website" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contactsFax">Fax</label>
                        <input class="form-control" type="text" name="contactsFax" id="contactsFax" v-model="contacts.fax" />
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="description">Description (max 400 symbols)</label>
                <textarea id="description" name="description" maxlength="400" rows="4" class="form-control"
                          v-model="profile.description"></textarea>
            </div>

            <div class="form-group">
                <label for="profile_picture" class="h6">Picture</label>

                <template v-if="profile.profile_picture">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="lawyer-avatar">
                                <img :src="profile.profile_picture" />
                            </div>
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-danger btn-sm" @click="removeImage">Remove</button>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <input id="profile_picture" name="profile_picture" type="file" class="form-control" accept="image/*" @change="onFileChange"/>
                </template>
            </div>

            <div class="row">
                <addresses :profile="profile" @change="loadProfile()"/>
                <employees :profile="profile" @change="loadProfile()"/>
            </div>

        </div>
    </div>
        <div class="card-footer">
            <a class="btn btn-minimal-danger" @click.stop.prevent="deactivateProfile()">Deactivate your account</a>
            <button class="btn btn-primary float-right" type="submit" @click.stop.prevent="updateProfile()">Save</button>
        </div>
    </div>
</template>

<script>
    import notie from 'notie';
    import Addresses from './Addresses';
    import Employees from './Employees';
    import NotifyHelper from '../mixins/NotifyHelper';
    import * as profileResource from '../resources/profile';

    export default {
        mixins: [NotifyHelper],
        components: {
            Addresses,
            Employees
        },
        created() {
            this.loadProfile();
        },
        methods: {
            loadProfile() {
                profileResource
                    .load()
                    .then(data => {
                        this.profile = data.data.profile;
                        this.contacts = this.formatContacts(data.data.profile.contacts);
                    });
            },
            updateProfile() {
                this.profile.contacts = this.contacts;

                profileResource
                    .update(this.profile)
                    .then(this.messageSuccess)
                    .catch(this.messageCatch)
                    .finally(() => {
                        this.profile.user.password = '';
                    });
            },
            deactivateProfile() {
                notie.confirm({
                    text: 'Are you sure you want to deactivate your account?',
                    submitCallback: () => {
                        profileResource
                            .deactivate(this.profile)
                            .then(location.replace('/'))
                            .catch(() => {
                                this.errors = ['server error'];
                            });
                    }
                });
            },
            formatContacts(contacts) {
                return contacts.reduce(function(map, obj) {
                    map[obj.type.toLowerCase()] = obj.value;
                    return map;
                }, {});
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    return;
                }
                this.createImage(files[0]);
            },
            createImage(file) {
                var reader = new FileReader();
                var vm = this.profile;

                reader.onload = (e) => {
                    vm.profile_picture = e.target.result;
                    vm.deletePicture = false;
                    vm.createPicture = true;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.profile.profile_picture = '';
                this.profile.deletePicture = true;
                this.profile.createPicture = false;
            }
        },
        data() {
            return {
                profile: {
                    user: {}
                },
                contacts: {},
                errors: []
            };
        }
    };
</script>
