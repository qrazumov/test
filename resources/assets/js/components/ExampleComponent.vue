<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Author tables</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Book_id</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="author in authors">
                        <td>{{ author.id }}</td>
                        <td>{{ author.name }}</td>
                        <td>{{ author.book_id }}</td>
                    </tr>
                    </tbody>
                </table>
                <h3>Book tables</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">title</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="book in books">
                        <td>{{ book.id }}</td>
                        <td>{{ book.title }}</td>
                    </tr>
                    </tbody>
                </table>
                <form>
                    <div class="form-group">
                        <label for="inputQuantity">Введите минимальное количество авторов, которые должны быть у книги</label>
                        <input v-model="qty" type="text" class="form-control" id="inputQuantity"
                               aria-describedby="inputQuantity" placeholder="Quantity">
                    </div>

                    <button @click.prevent="setQty" type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h5>Основной запрос</h5>
                <code>
                    SELECT
                    id, title, book_ids.cnt
                    FROM
                    library.books
                    INNER JOIN
                    (SELECT
                    COUNT(book_id) AS cnt, book_id
                    FROM
                    library.authors
                    GROUP BY book_id
                    HAVING cnt >= $count) AS book_ids ON library.books.id = book_ids.book_id
                </code>
                <table class="table" v-show="isShowTaskTable">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">title</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="tItem in task">
                        <td>{{ tItem.id }}</td>
                        <td>{{ tItem.title }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <h3>Задача по js</h3>
                <form>
                    <div class="form-group">
                        <label for="inputMessage">Текст</label>
                        <input @keyup="replaceSmile()" v-model="message" type="text" class="form-control"
                               id="inputMessage" aria-describedby="inputMessage" placeholder="Message">
                    </div>
                </form>
                <h5 id="msgContainer"></h5>
                <h5> Рефакторинг 1 вариант</h5>
                <pre>
                function drawRatingRefactoring(vote) {

                    for (let i = 0, j = 1; i < 100, i = i + 20, j++;) {
                        if (i < vote) {
                            continue;
                        }
                        else {
                            let str = '-----';
                            for (let m = 1; m < j; m++) {
                                str = str.replace('-', '*');
                            }
                            return str;
                        }
                    }

                }
                </pre>
                <h5> Рефакторинг 2 вариант</h5>
                <pre>
                function drawRatingRefactoring2(vote) {

                    let result = Math.floor(vote / 20);
                    if (vote === 0) result = 1;
                    let ost = vote % 20;
                    ost === 0 ? result : result = result + 1;
                    let str = '-----';
                    for (let m = 1; m < result + 1; m++) {
                        str = str.replace('-', '*');
                    }
                    return str;

                }
                </pre>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h3>Понимание атмосферы:</h3>
                <a href="/save" target="_blank">Сохранить файл</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                authors: [],
                books: [],
                qty: 2,
                task: [],
                isShowTaskTable: false,
            }
        },
        methods: {
            setQty: function () {
                let self = this;
                axios.get('/task', {
                    params: {
                        qty: self.qty
                    }
                })
                    .then(function (response) {
                        console.log(response);
                        if (response.data !== false) {
                            self.task = response.data;
                            self.isShowTaskTable = true;
                        } else {
                            alert('Books do not exist or incorrect inputs data');
                            self.isShowTaskTable = false;
                        }

                    })
                    .catch(function (error) {
                        self.isShowTaskTable = false;
                        console.log(error);
                    });
            },
            // приторомозим выполнение на 1500 мс
            replaceSmile: _.debounce(function () {
                const replace = ":)";
                const regex = /\)+/g;
                let message = this.message.replace(regex, replace);
                $('#msgContainer').text(message);
            }, 1500)
        },

        created() {
            let self = this;
            axios.get('/authors')
                .then(function (response) {
                    console.log(response);
                    self.authors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/books')
                .then(function (response) {
                    console.log(response);
                    self.books = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });


            // рефакторинг
            function drawRating(vote) {
                if (vote >= 0 && vote <= 20) {
                    return '*----';
                }
                else if (vote > 20 && vote <= 40) {
                    return '**---';
                }
                else if (vote > 40 && vote <= 60) {
                    return '***--';
                }
                else if (vote > 60 && vote <= 80) {
                    return '****-';
                }
                else if (vote > 80 && vote <= 100) {
                    return '*****';
                }
            }


            function drawRatingRefactoring(vote) {

                for (let i = 0, j = 1; i < 100, i = i + 20, j++;) {
                    if (i < vote) {
                        continue;
                    }
                    else {
                        let str = '-----';
                        for (let m = 1; m < j; m++) {
                            str = str.replace('-', '*');
                        }
                        return str;
                    }
                }

            }

            function drawRatingRefactoring2(vote) {

                let result = Math.floor(vote / 20);
                if (vote === 0) result = 1;
                let ost = vote % 20;
                ost === 0 ? result : result = result + 1;
                let str = '-----';
                for (let m = 1; m < result + 1; m++) {
                    str = str.replace('-', '*');
                }
                return str;

            }

            // тесты на множестве
            for (let f = 0; f <= 100; f++) {
                if (drawRating(f) !== drawRatingRefactoring(f)
                ) {
                    console.log('Ошибка на ' + f);
                }
                else {
                    console.log('Пройден на ' + f);
                }

                if (
                    drawRating(f) !== drawRatingRefactoring2(f)

                ) {
                    console.log('Ошибка на ' + f);
                }
                else {
                    console.log('Пройден на ' + f);
                }

                if (

                    drawRatingRefactoring(f) !== drawRatingRefactoring2(f)
                ) {
                    console.log('Ошибка на ' + f);
                }
                else {
                    console.log('Пройден на ' + f);
                }

            }

        },

    }
</script>
<style scoped>
    .table {
        font-size: 14px;
    }
</style>
