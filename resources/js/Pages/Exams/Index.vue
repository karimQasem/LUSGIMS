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
import Dropdown from 'primevue/dropdown';
import useRoute from '@/Hooks/useRoute';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import ConfirmPopup from 'primevue/confirmpopup';
import { useConfirm } from "primevue/useconfirm";
import Calendar from 'primevue/calendar';
const route = useRoute();
const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
    exams: {
        type: Array as PropType<App.Models.Exam[]>,
        required: true
    },
    courses: {
        type: Array as PropType<App.Models.Cours[]>,
        required: true
    },
    teachers: {
        type: Array as PropType<App.Models.Teacher[]>,
        required: true
    }
});

const displayDialog = ref<boolean>(false);
const displayDialogEdit = ref<boolean>(false);
const selectedexam = ref<App.Models.Exam>();

const form = useForm({
    exam_date: <string | Date | string[] | Date[] | undefined>"",
    teacher_id: <number | null>null,
    cours_id: <number | null>null,

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
    form.post(route("exams.store"), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'Exams a été créé avec succès', life: 3000 });
            resetForm();
            closeDialog();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const edit = (data: App.Models.Exam): void => {
    selectedexam.value = data;
    Object.assign(form, data);
    openDialogEdit();
}
const update = (id) => {
    form.put(route("exams.update", { exam: id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'Exam a été bien modifier', life: 3000 });
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
            form.delete(route("exams.destroy", { exam: id }), {
                onSuccess: () => {
                    toast.add({ severity: 'info', summary: 'Message de réussite', detail: 'Exam a été bien supprimer', life: 3000 });
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

    <Head title="Exams" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List des Exams</h2>
        </template>
        <Toolbar>
            <template #start>
                <Button label="Nouveau" icon="pi pi-plus" class="p-button-success mr-2" @click="openDialog()" />
            </template>
        </Toolbar>
        <DataTable showGridlines :value="exams" responsiveLayout="scroll" :paginator="true" :rows="4">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">Gérer les exams</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText placeholder="Search..." />
                    </span>
                </div>
            </template>
            <Column class="uppercase" field="id" header="id" :sortable="true"></Column>
            <Column class="uppercase" field="cours.name" header="Cours" :sortable="true"></Column>
            <Column class="uppercase" field="teacher.first_name" header="Prof" :sortable="true"></Column>
            <Column class="uppercase" field="exam_date" header="Date examen" :sortable="true"></Column>
            <Column class="uppercase" field="created_at" header="created_at" :sortable="true"></Column>
            <Column class="uppercase" field="updated_at" header="updated_at" :sortable="true"></Column>
            <Column class="uppercase" field="action" header="action">
                <template #body="slotProps">
                    <div class="flex flex-col space-y-1">
                        <Button label="Modifier" icon="pi pi-pencil" class="p-button-info uppercase"
                            @click="edit(slotProps.data)" />
                        <Button label="Supprimer" icon="pi pi-trash" class="p-button-danger uppercase"
                            @click="destroy(slotProps.data.id, $event)" />
                    </div>

                </template>
            </Column>
        </DataTable>

        <!-- Create dialog -->
        <Dialog header="Nouveau examen" v-model:visible="displayDialog"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>Professeur</label>
                    <Dropdown v-model="form.teacher_id" :options="teachers" optionLabel="first_name"
                        placeholder="Sélectionnez un Professeur" :filter="true"
                        filterPlaceholder="Chercher un Professeur" class="w-full" optionValue="id"
                        v-bind:class="{ 'p-invalid': form.errors.teacher_id }" />
                    <small class="p-error" v-show="form.errors.teacher_id">{{ form.errors.teacher_id }}</small>
                </div>
                <div>
                    <label>Course</label>
                    <Dropdown v-model="form.cours_id" :options="courses" optionLabel="name"
                        placeholder="Sélectionnez un Course" :filter="true" filterPlaceholder="Chercher un Course"
                        class="w-full" optionValue="id" v-bind:class="{ 'p-invalid': form.errors.cours_id }" />
                    <small class="p-error" v-show="form.errors.cours_id">{{ form.errors.cours_id }}</small>
                </div>
                <div class="flex flex-col ">
                    <label>Date de examen</label>
                    <Calendar v-model="form.exam_date" dateFormat="dd-mm-yy" :showTime="true"
                        v-bind:class="{ 'p-invalid': form.errors.exam_date }" />
                    <small class="p-error" v-show="form.errors.exam_date">{{ form.errors.exam_date }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="resetForm()" />
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus @click="submit()"
                    :loading="form.processing" />
            </template>
        </Dialog>

        <!-- Edit dialog -->
        <Dialog header="Modifier le examen" v-model:visible="displayDialogEdit"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>Professeur</label>
                    <Dropdown v-model="form.teacher_id" :options="teachers" optionLabel="first_name"
                        placeholder="Sélectionnez un Professeur" :filter="true"
                        filterPlaceholder="Chercher un Professeur" class="w-full" optionValue="id"
                        v-bind:class="{ 'p-invalid': form.errors.teacher_id }" />
                    <small class="p-error" v-show="form.errors.teacher_id">{{ form.errors.teacher_id }}</small>
                </div>
                <div>
                    <label>Course</label>
                    <Dropdown v-model="form.cours_id" :options="courses" optionLabel="name"
                        placeholder="Sélectionnez un Course" :filter="true" filterPlaceholder="Chercher un Course"
                        class="w-full" optionValue="id" v-bind:class="{ 'p-invalid': form.errors.cours_id }" />
                    <small class="p-error" v-show="form.errors.cours_id">{{ form.errors.cours_id }}</small>
                </div>
                <div class="flex flex-col ">
                    <label>Date de examen</label>
                    <Calendar v-model="form.exam_date" dateFormat="dd-mm-yy" :showTime="true"
                        v-bind:class="{ 'p-invalid': form.errors.exam_date }" />
                    <small class="p-error" v-show="form.errors.exam_date">{{ form.errors.exam_date }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus
                    @click="update(selectedexam?.id)" :loading="form.processing" />
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
