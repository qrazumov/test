<template>
    <div>
        <h3 v-show="isSuccess">Файл успешно сохранен</h3>
        <h3 v-show="isError">Ошибка записи файла</h3>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isSuccess: false,
                isError: false,
            }
        },
        methods: {

        },

        created() {
            let self = this;
            axios.get('/file', {
                params: {
                    width: screen.width,
                    height: screen.height,
                }
            })
                .then(function (response) {
                    console.log(response);
                    self.isSuccess = true;
                })
                .catch(function (error) {
                    console.log(error);
                    self.isError = true;
                });
        },

    }
</script>

<style scoped>

</style>
