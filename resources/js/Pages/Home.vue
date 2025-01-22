<template>
    <div class="max-w-4xl mx-auto p-6">
      <h1 class="text-2xl font-semibold mb-4">Lista de Trechos</h1>
  
      <button
        @click="goToCreatePage"
        class="bg-green-500 text-white p-2 rounded mb-4"
      >
        Criar Novo Trecho
      </button>
  
      <table class="min-w-full table-auto border-collapse mb-6">
        <thead>
          <tr>
            <th class="border p-2 text-left">Data de Referência</th>
            <th class="border p-2 text-left">UF</th>
            <th class="border p-2 text-left">Rodovia</th>
            <th class="border p-2 text-left">Tipo</th>
            <th class="border p-2 text-left">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="trecho in trechos" :key="trecho.id">
            <td class="border p-2">{{ trecho.data_referencia }}</td>
            <td class="border p-2">{{ trecho.uf.sigla }}</td>
            <td class="border p-2">{{ trecho.rodovia.br }}</td>
            <td class="border p-2">{{ trecho.tipo }}</td>
            <td class="border p-2">
              <button
                @click="goToEditPage(trecho.id)"
                class="bg-yellow-500 text-white p-1 rounded mr-2"
              >
                Editar
              </button>
              <button
                @click="goToShowPage(trecho.id)"
                class="bg-blue-500 text-white p-1 mr-2 rounded"
              >
                Detalhes
              </button>
              <button
                @click="deleteTrecho(trecho.id)"
                class="bg-red-500 text-white p-1 rounded"
              >
                Excluir
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        trechos: [],
      };
    },
    mounted() {
      this.fetchTrechos();
    },
    methods: {
      async fetchTrechos() {
        try {
          const response = await axios.get("/trechos");
          this.trechos = response.data;
        } catch (error) {
          console.error(error);
          alert("Erro ao carregar os trechos.");
        }
      },
      goToCreatePage() {
        window.location.href = '/create';
      },
      goToShowPage(id) {
        window.location.href = `/detalhes/${id}`;
      },
      goToEditPage(id) {
        window.location.href = `/editar/${id}`;
      },
      async deleteTrecho(id) {
        if (confirm("Tem certeza que deseja excluir este trecho?")) {
          try {
            await axios.delete(`/trechos/${id}`);
            this.fetchTrechos();
          } catch (error) {
            console.error(error);
            alert("Erro ao excluir o trecho.");
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>

  </style>
  