<template>
    <div class="col-md-6">
        <label for="employees" class="h6">Employees</label>
        <ul class="styled-list" id="employees">
            <li v-for="(employee, index) in employees" :key="index">
                {{ employee.name }}

                <button type="button" class="btn btn-sm btn-minimal-danger"
                        @click.stop.prevent="removeEmployee(employee)">
                    Remove
                </button>
            </li>
        </ul>

        <div class="form-group clearfix">
            <button class="btn btn-primary" @click.stop.prevent="openModal('employee')">
                add employee
            </button>
        </div>

        <Modal size="large" v-if="currentModal === 'employee'" @close="closeModals()">
            <div slot="title">Add employee</div>
            <div slot="body">
                <form-errors :errors="errors"></form-errors>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" v-model="employee.name" type="text" class="form-control" />
                </div>

            </div>
            <div slot="footer">
                <button class="btn btn-default" @click.stop.prevent="closeModals()">Cancel</button>
                <button class="btn btn-primary" @click.stop.prevent="addEmployee()">Save</button>
            </div>
        </Modal>
    </div>
</template>
<script>
    import notie from 'notie';
    import OpensModals from '../mixins/OpensModals';
    import NotifyHelper from '../mixins/NotifyHelper';
    import * as employeeResource from '../resources/employee';
    import VueSelect from 'vue-select';

    export default {
        mixins: [OpensModals, NotifyHelper],
        props: ['profile'],
        components: {
            VueSelect
        },
        methods: {
            add() {
                employeeResource
                    .add(this.employee)
                    .then(() => {
                        this.messageSuccess();
                        this.closeModals();
                        this.employee = {};
                    })
                    .catch((data) => {
                        this.messageCatch(data);

                        if (data.response.status !== 422) {
                            this.closeModals();
                            this.employee = {};
                        }
                    })
                    .finally(() => {
                        this.$emit('change');
                    });
            },
            remove(employee) {
                notie.confirm({
                    text: 'Are you sure you want to remove this employee?',
                    submitCallback: () => {
                        employeeResource
                            .remove(employee)
                            .then(() => {
                                this.messageSuccess();
                                this.$emit('change');
                            });
                    }
                });
            },
            addEmployee() {
                this.add();
            },
            removeEmployee(employee) {
                this.remove(employee);
            },
            beforeOpenModals() {
                this.errors = [];
            },
            beforeCloseModals() {
                this.employee = {};
                this.options = [];
            }
        },
        computed: {
            employees() {
                return this.profile.employees;
            }
        },
        data() {
            return {
                options: [],
                employee: {},
                errors: []
            };
        }
    };
</script>