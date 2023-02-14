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
import Dropdown from 'primevue/dropdown';
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
    teachers: {
        type: Array as PropType<App.Models.Teacher[]>,
        required: true
    },
    users: {
        type: Array as PropType<App.Models.User[]>,
        required: true
    },
    displayDialog: {
        type: Boolean,
        default: false
    }
});

const displayDialog = ref<boolean>(false);
const displayDialogEdit = ref<boolean>(false);
const selectedteacher = ref<App.Models.Teacher>();

const form = useForm({
    first_name: <string | null>"",
    last_name: <string | null>"",
    specialty: <string | null>"",
    academic_degree: <string | null>"",
    phone_number: <string | null>null,
    email: <string | null>null,
    user_id: <number | null>null
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
    form.post(route("teachers.store"), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'Le enseignant a été créé avec succès', life: 3000 });
            resetForm();
            closeDialog();
        },
        onError: () => {
            console.log(form.errors);
        },
        onFinish: () => { },
    });
}

const edit = (data: App.Models.Teacher): void => {
    selectedteacher.value = data;
    Object.assign(form, data);
    openDialogEdit();
}
const update = (id) => {
    form.put(route("teachers.update", { teacher: id }), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Message de réussite', detail: 'Le enseignant a été bien modifier', life: 3000 });
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
            form.delete(route("teachers.destroy", { teacher: id }), {
                onSuccess: () => {
                    toast.add({ severity: 'info', summary: 'Message de réussite', detail: 'Le enseignant a été bien supprimer', life: 3000 });
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

    <Head title="Enseignants" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List des enseignants</h2>
        </template>
        <Toolbar>
            <template #start>
                <Button label="Nouveau" icon="pi pi-plus" class="p-button-success mr-2" @click="openDialog()" />
            </template>
        </Toolbar>
        <DataTable showGridlines :value="teachers" responsiveLayout="scroll" :paginator="true" :rows="4">
            <template #header>
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">Gérer les enseignants</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText placeholder="Search..." />
                    </span>
                </div>
            </template>
            <Column class="uppercase" field="id" header="id" :sortable="true"></Column>
            <Column class="uppercase" field="first_name" header="first_name" :sortable="true"></Column>
            <Column class="uppercase" field="last_name" header="last_name" :sortable="true"></Column>
            <Column class="uppercase" field="specialty" header="specialty" :sortable="true"></Column>
            <Column class="uppercase" field="phone_number" header="phone_number" :sortable="true"></Column>
            <Column class="uppercase" field="email" header="email" :sortable="true"></Column>
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
        <Dialog header="Nouveau enseignant" v-model:visible="displayDialog"
            :breakpoints="{ '960px': '75vw', '640px': '90vw' }" :style="{ width: '50vw' }" :maximizable="true"
            :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>first_name</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.first_name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.first_name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.first_name">{{ form.errors.first_name }}</small>
                </div>
                <div>
                    <label>last_name</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.last_name" placeholder="last_name" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.last_name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.last_name">{{ form.errors.last_name }}</small>
                </div>
                <div>
                    <label>specialty</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.specialty" placeholder="specialty" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.specialty }" />

                    </span>
                    <small class="p-error" v-show="form.errors.specialty">{{ form.errors.specialty }}</small>
                </div>
                <div>
                    <label>academic_degree</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.academic_degree" placeholder="academic_degree"
                            class="w-full" v-bind:class="{ 'p-invalid': form.errors.academic_degree }" />
                    </span>
                    <small class="p-error" v-show="form.errors.academic_degree">{{
                        form.errors.academic_degree
                    }}</small>
                </div>
                <div>
                    <label>phone_number</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.phone_number" placeholder="phone_number" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.phone_number }" />
                    </span>
                    <small class="p-error" v-show="form.errors.phone_number">{{
                        form.errors.phone_number
                    }}</small>
                </div>
                <div>
                    <label>email</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.email" placeholder="email" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.email }" />
                    </span>
                    <small class="p-error" v-show="form.errors.email">{{
                        form.errors.email
                    }}</small>
                </div>
                <div>
                    <label for="username1">Utilisateur</label>
                    <Dropdown v-model="form.user_id" :options="users" optionLabel="name"
                        placeholder="Sélectionnez un Utilisateur" :filter="true"
                        filterPlaceholder="Chercher un Utilisateur" class="w-full" optionValue="id"
                        v-bind:class="{ 'p-invalid': form.errors.user_id }" />
                    <small class="p-error" v-show="form.errors.user_id">{{ form.errors.user_id }}</small>
                </div>


            </div>

            <template #footer>
                <Button label="Annuler" icon="pi pi-times" class="p-button-text" @click="resetForm()" />
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus @click="submit()"
                    :loading="form.processing" />
            </template>
        </Dialog>

        <!-- Edit dialog -->
        <Dialog :header="'Modifier le enseignant ' + form.first_name + ' ' + form.last_name"
            v-model:visible="displayDialogEdit" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
            :style="{ width: '50vw' }" :maximizable="true" :modal="true">
            <div class="flex flex-col space-y-2 w-full">
                <div>
                    <label>first_name</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.first_name" placeholder="Nom" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.first_name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.first_name">{{ form.errors.first_name }}</small>
                </div>
                <div>
                    <label>last_name</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.last_name" placeholder="last_name" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.last_name }" />

                    </span>
                    <small class="p-error" v-show="form.errors.last_name">{{ form.errors.last_name }}</small>
                </div>
                <div>
                    <label>specialty</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-hashtag" />
                        <InputText type="text" v-model="form.specialty" placeholder="specialty" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.specialty }" />

                    </span>
                    <small class="p-error" v-show="form.errors.specialty">{{ form.errors.specialty }}</small>
                </div>
                <div>
                    <label>academic_degree</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.academic_degree" placeholder="academic_degree"
                            class="w-full" v-bind:class="{ 'p-invalid': form.errors.academic_degree }" />
                    </span>
                    <small class="p-error" v-show="form.errors.academic_degree">{{
                        form.errors.academic_degree
                    }}</small>
                </div>
                <div>
                    <label>phone_number</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.phone_number" placeholder="phone_number" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.phone_number }" />
                    </span>
                    <small class="p-error" v-show="form.errors.phone_number">{{
                        form.errors.phone_number
                    }}</small>
                </div>
                <div>
                    <label>email</label>
                    <span class="p-input-icon-left w-full">
                        <i class="pi pi-clock" />
                        <InputText type="text" v-model="form.email" placeholder="email" class="w-full"
                            v-bind:class="{ 'p-invalid': form.errors.email }" />
                    </span>
                    <small class="p-error" v-show="form.errors.email">{{
                        form.errors.email
                    }}</small>
                </div>
                <div>
                    <label for="username1">Utilisateur</label>
                    <Dropdown v-model="form.user_id" :options="users" optionLabel="name"
                        placeholder="Sélectionnez un Utilisateur" :filter="true"
                        filterPlaceholder="Chercher un Utilisateur" class="w-full" optionValue="id"
                        v-bind:class="{ 'p-invalid': form.errors.user_id }" />
                    <small class="p-error" v-show="form.errors.user_id">{{ form.errors.user_id }}</small>
                </div>


            </div>

            <template #footer>
                <Button label="Soumettre" icon="pi pi-check" class="p-button-success" autofocus
                    @click="update(selectedteacher?.id)" :loading="form.processing" />
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
