<template>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-7">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Editar Trecho</h1>
  
      <form @submit.prevent="updateTrecho">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="flex flex-col">
            <label for="data_referencia" class="text-gray-700 font-medium">Data de Referência</label>
            <input
              type="date"
              id="data_referencia"
              v-model="form.data_referencia"
              class="w-full p-2 border rounded"
            />
          </div>
  
          <div class="flex flex-col">
            <label for="tipo_trecho" class="text-gray-700 font-medium">Tipo de Trecho</label>
            <select
              id="tipo_trecho"
              v-model="form.tipo"
              class="w-full p-2 border rounded"
            >
              <option value="B">B</option>
              <option value="U">U</option>
            </select>
          </div>
        </div>
  
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
          <div class="flex flex-col">
            <label for="uf" class="text-gray-700 font-medium">Unidade da Federação</label>
            <select
              id="uf"
              v-model="form.uf"
              class="w-full p-2 border rounded"
            >
              <option v-for="uf in ufs" :key="uf.id" :value="uf">{{ uf.nome }}</option>
            </select>
          </div>
  
          <div class="flex flex-col">
            <label for="rodovia" class="text-gray-700 font-medium">Rodovia</label>
            <select
              id="rodovia"
              v-model="form.rodovia"
              class="w-full p-2 border rounded"
            >
              <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia">
                BR-{{ rodovia.br }}
              </option>
            </select>
          </div>
        </div>
  
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
          <div class="flex flex-col">
            <label for="km_inicial" class="text-gray-700 font-medium">Quilometragem Inicial</label>
            <input
              type="number"
              id="km_inicial"
              v-model="form.km_inicial"
              class="w-full p-2 border rounded"
            />
          </div>
  
          <div class="flex flex-col">
            <label for="km_final" class="text-gray-700 font-medium">Quilometragem Final</label>
            <input
              type="number"
              id="km_final"
              v-model="form.km_final"
              class="w-full p-2 border rounded"
            />
          </div>
        </div>
  
        <div class="mt-6 text-center">
          <button
            type="submit"
            class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600"
          >
            Salvar Alterações
          </button>

          <a
            href="/"
            class="inline-block bg-gray-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-gray-600 ml-2"
          >
            Voltar para a lista
          </a>
        </div>
      </form>
  
      <div v-if="successMessage" class="mt-4 p-2 bg-green-500 text-white text-center">
        {{ successMessage }}
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        form: {
          data_referencia: "",
          tipo: "",
          uf: "",
          rodovia: "",
          km_inicial: "",
          km_final: "",
        },
        successMessage: "",
        ufs: [],
        rodovias: [],
      };
    },
    mounted() {
      this.fetchUfs();
      this.fetchRodovias();
      this.fetchTrechoDetails();
    },
    methods: {
      fetchUfs() {
        axios.get("/ufs").then((response) => {
          this.ufs = response.data;
        });
      },
      fetchRodovias() {
        axios.get("/rodovias").then((response) => {
          this.rodovias = response.data;
        });
      },
      fetchTrechoDetails() {
        const id = window.location.pathname.split("/").pop();
        axios
          .get(`/trechos/${id}`)
          .then((response) => {
            const trecho = response.data;
            this.form = {
              data_referencia: trecho.data_referencia,
              tipo: trecho.tipo,
              uf: trecho.uf,
              rodovia: trecho.rodovia,
              km_inicial: trecho.km_inicial,
              km_final: trecho.km_final,
            };
          })
          .catch((error) => {
            console.error("Erro ao carregar os detalhes do trecho:", error);
            alert("Erro ao carregar os detalhes do trecho.");
          });
      },
      updateTrecho() {
        const id = window.location.pathname.split("/").pop();
        axios
          .put(`/trechos/${id}`, this.form)
          .then(() => {
            this.successMessage = "Trecho atualizado com sucesso!";
            setTimeout(() => {
              window.location.href = `/`;
            }, 2000);
          })
          .catch((error) => {
            console.error("Erro ao atualizar o trecho:", error);
            alert("Erro ao atualizar o trecho.");
          });
      },
    },
  };
  </script>
  
  <style scoped>
  </style>
  