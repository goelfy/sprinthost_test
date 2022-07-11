<script setup>

import {ref, reactive, onMounted} from 'vue';
import axios from 'axios';
import route from 'ziggy-js';
import Animal from './Animal.vue';
import Preloader from "./Preloader.vue";

const ageing_after = ref(5); // Количество секунд для автоматического роста

const app = reactive({
    session_id: null, // Идентификатор сессии
    preloader: 0, // Храним число выполняемых задач для прелоадера
    animal_kinds: new Map(), // Коллекция видов животных
    animals: [], // Созданные животные
    timer: 0, // Сколько времени прошло после последнего роста. Нужно для автоматического роста
    max_animal_size: 0, // Размер самого упитанного животного
    interval_id: null
});

/*
* Добавляет size_percent к записи из app.animals
* size_percent - размер в процентах от максимально возможного
* */
function setPercent(row) {
    row.size_percent = row.size / app.max_animal_size * 100;
    return row;
}

/*
* Получаем все виды животных
* */
function loadAnimalKind() {
    app.preloader++;
    axios.get(route('animal_kinds')).then((response) => {
        for (const row of response.data) {
            row.available = true;
            app.max_animal_size = Math.max(row.max_size, app.max_animal_size);
            app.animal_kinds.set(row.id, row);
        }
        app.interval_id = setInterval(ageAnimals, 1000);
    }).finally(() => {
        console.log('animal_kinds', app.preloader--);
    });
}

/*
* Создаем сессию
* Для простой связи между текущими данными
* */
function startSession() {
    app.preloader++;
    axios.get(route('animal_session.create')).then((response) => {
        app.session_id = response.data.id;
        loadAnimalKind();
    }).finally(() => app.preloader--);
}

/*
* Рост животных
* */
function ageAnimals() {
    if (ageing_after.value <= app.timer) {

        axios.post(route('animal.age'), {
            session_id: app.session_id
        }).then((response) => {
            app.animals = response.data.map(setPercent);
        }).finally(() => app.preloader--);

        app.timer = 0;
    } else {
        app.timer++;
    }
}

/*
* Создаем новое животное
* */
function addAnimal() {
    let animal_kind = Array.from(app.animal_kinds.values()).filter(a => a.available);

    if (animal_kind.length) {
        app.preloader++;
        let i = Math.floor(Math.random() * animal_kind.length);
        app.animal_kinds.get(animal_kind[i].id).available = false;

        axios.post(route('animal.create'), {
            session_id: app.session_id,
            animal_kind_id: animal_kind[i].id,
        }).then((response) => {
            app.animals.push(setPercent(response.data));
        }).catch(() => {
            app.animal_kinds.get(animal_kind[i].id).available = true;
            console.log('Не удалось создать животное')
        }).finally(() => app.preloader--);
    }

}


onMounted(startSession)

</script>

<template>
    <Preloader v-if="app.preloader > 0"/>
    <div class="p-4">

        <div v-if="app.animal_kinds.size > 0" class="panel">

            <button v-if="app.animals" @click="addAnimal"
                    class="panel-btn">
                <span class="material-symbols-outlined flex-none text-3xl">add</span>
            </button>

            <div class="panel-animal">
                <div v-for="animal_kind of app.animal_kinds"
                     class="panel-animal-avatar"
                     :class="{'opacity-30': !animal_kind[1].available}">
                    <img :src="animal_kind[1].img" :alt="animal_kind[1].name" :title="animal_kind[1].name">
                </div>
            </div>

            <span class="pl-6 pr-2">Скорость роста</span>

            <input v-model="ageing_after" type="number"
                   class="py-2 px-4 rounded-lg border border-gray-400 outline-0 w-20">

            <div v-if="app.interval_id && app.animals.length > 0" class="ml-4 opacity-25">
                Рост через {{ ageing_after - app.timer }} сек
            </div>

        </div>

        <div class="animal-list mt-4">
            <Animal v-for="animal in app.animals"
                    :animal-kind="app.animal_kinds.get(animal.animal_kind_id)"
                    :animal="animal"
            />
        </div>

    </div>

</template>
