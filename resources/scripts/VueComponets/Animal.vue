<script setup>
const props = defineProps(['animal', 'animalKind']);
</script>

<template>
    <div class="animal-list-item">
        <img :src="props.animalKind.img" class="animal-list-item-img" :style="{ width: props.animal.size_percent + '%' }" :alt="props.animalKind.name">
        <b>{{ props.animalKind.name }}</b><br>
        age - {{ props.animal.age }}/{{ props.animalKind.max_age }}<br>
        size - {{ props.animal.size }}/{{ props.animalKind.max_size }}<br>
        growth factor - {{ props.animalKind.growth_factor }}<br>
    </div>
</template>
