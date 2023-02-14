<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType, ref } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import InputNumber from 'primevue/inputnumber';
import useRoute from '@/Hooks/useRoute';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm";
const route = useRoute();
const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
    filieres: {
        type: Array as PropType<App.Models.Filiere[]>,
        required: true
    },
});

const displayDialog = ref<boolean>(false);
const displayDialogEdit = ref<boolean>(false);
const selectedfiliere = ref<App.Models.Filiere>();

const form = useForm({
    name: <string | null>"",
    description: <string | undefined>"",
    number_hours: <number>0
});

const openDialog = () => {
    resetForm();
    displayDialog.value = true;
};
const closeDialog = () => {
    displayDialog.value = false;
};

const openDialogEdit = () => {
    displayDialogEdit.value = true;
};
const closeDialogEdit = () => {
    displayDialogEdit.value = false;
};

const resetForm = () => {
    form.reset();
}

const submit = () => {
    form.post(route("filieres.store"), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'La filier a été créé avec succès', life: 3000 });
            resetForm();
            closeDialog();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const edit = (data: App.Models.Filiere): void => {
    selectedfiliere.value = data;
    Object.assign(form, data);
    openDialogEdit();
}
const update = (id) => {
    form.put(route("filieres.update", { filiere: id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'La filier a été bien modifier', life: 3000 });
            resetForm();
            closeDialogEdit();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const destroy = (id, event) => {
    confirm.require({
        target: event.currentTarget,
        message: 'Êtes-vous sur de vouloir continuer?',
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => {
            //callback to execute when user confirms the action
            form.delete(route("filieres.destroy", { filiere: id }), {
                onSuccess: () => {
                    toast.add({ severity: 'info', summary: 'Message de réussite', detail: 'La filier a été bien supprimer', life: 3000 });
                    resetForm();
                    closeDialogEdit();
                },
                onError: () => {
                    console.log(form.errors);
                },
                onFinish: () => { },
            });
        },
        reject: () => {
            //callback to execute when user rejects the action
        },
    });

}
</script>

<template>

    <Head title="filiers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List des filiers</h2>
        </template>
        <Toolbar>
            <template #start>
                <Button label="Nouveau" icon="pi pi-plus" class="p-button-success mr-2" @click="openDialog()" />
            </template>
        </Toolbar>
        <DataTable showGridlines :value="filieres" responsiveLayout="scroll" :paginator="true" :rows="4">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">Gérer les filiers</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText placeholder="Search..." />
                    </span>
                </div>
            </template>
            <Column class="uppercase" field="id" header="id" :sortable="true"></Column>
            <Column class="uppercase" field="name" header="name" :sortable="true"></Column>
            <Column class="uppercase" field="description" header="description" :sortable="true"></Column>
            <Column class="uppercase" field="number_hours" header="Nombre des heurs" :sortable="true"></Column>
            <Column class="uppercase" field="created_at" header="created_at" :sortable="true"></Column>
            <Column class="uppercase" field="updated_at" header="updated_at" :sortable="true"></Column>
            <Column class="uppercase" field="action" header="action">
                <template #body="slotProps">
                    <div class="flex flex-col space-y-1">
                        <Button label="Cours" icon="pi pi-book" class="p-button-success uppercase" />
                        <Button label="Modifier" icon="pi pi-pencil" class="p-button-info uppercase"
                            @click="edit(slotProps.data)" />
                        <Button label="Supprimer" icon="pi pi-trash" class="p-button-danger uppercase"
                            @click="destroy(slotProps.data.id, $event)" />
                    </div>

                </template>
            </Column>
        </DataTable>

        <!-- Create dialog -->
        <Dialog header="Nouveau filiere" v-model:visible="displayDialog"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label for="username1">Nom</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.name">{{ form.errors.name }}</small>
                </div>
                <div>
                    <label for="username1">Description</label>
                    <Textarea v-model="form.description" rows="5" cols="30" placeholder="Description" class="w-full" />
                </div>
                <div>
                    <label for="username1">Nombre d'heures</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputNumber type="text" v-model="form.number_hours" placeholder="nombre d'heures"
                            class="w-full p-inputtex" v-bind:class="{ 'p-invalid': form.errors.number_hours }" />
                    </span>
                    <small class="p-error" v-show="form.errors.number_hours">{{ form.errors.number_hours }}</small>
                </div>
            </div>
            <template #footer>
                <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="resetForm()" />
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus @click="submit()"
                    :loading="form.processing" />
            </template>
        </Dialog>

        <!-- Edit dialog -->
        <Dialog :header="'Modifier la filiere ' + form.name" v-model:visible="displayDialogEdit"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label for="username1">Nom</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.name">{{ form.errors.name }}</small>
                </div>
                <div>
                    <label for="username1">Description</label>
                    <Textarea v-model="form.description" rows="5" cols="30" placeholder="Description" class="w-full" />
                </div>
                <div>
                    <label for="username1">Nombre d'heures</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputNumber type="text" v-model="form.number_hours" placeholder="nombre d'heures"
                            class="w-full p-inputtex" v-bind:class="{ 'p-invalid': form.errors.number_hours }" />
                    </span>
                    <small class="p-error" v-show="form.errors.number_hours">{{ form.errors.number_hours }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus
                    @click="update(selectedfiliere?.id)" :loading="form.processing" />
            </template>
        </Dialog>
    </AuthenticatedLayout>
    <ConfirmPopup></ConfirmPopup>
    <Toast />
</template>
<style lang="scss" scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @media screen and (max-width: 960px) {
        align-items: start;
    }

    .sizes {
        .p-inputtext {
            display: block;
            margin-bottom: .5rem;

            &:last-child {
                margin-bottom: 0;
            }
        }
    }

    .field * {
        display: block;
    }
}
</style>
