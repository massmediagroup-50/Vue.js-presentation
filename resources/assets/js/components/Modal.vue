<template>
    <div class="modal-wrap">
        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true" style="display: block;">
            <div :class="getClasses()" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title"><slot name="title">Modal title</slot></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click.stop="$emit('close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="body">Modal body</slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop in">&nbsp;</div>
    </div>
</template>
<script>
    import $ from 'jquery';
    export default {
        props: {
            size: {
                default: 'default'
            }
        },
        mounted () {
            const _this = this;
            $('body').on('keyup', function(e) {
                if (e.keyCode === 27) {
                    _this.$emit('close');
                }
                if (e.keyCode === 13) {
                    _this.$emit('submit');
                }
            });
            $(this.$el).removeClass('hidden');
            document.body.className += ' modal-open';
        },
        methods: {
            getClasses() {
                return {
                    'modal-dialog': true,
                    'modal-lg': this.size === 'large'
                };
            }
        },
        beforeDestroy () {
            document.body.className = document.body.className.replace(/\s?modal-open/, '');
        }
    };
</script>