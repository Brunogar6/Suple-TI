<template>
    <div class="max-w-2xl mx-auto p-6">
      <h1 class="text-2xl font-semibold mb-4">Criar Trecho</h1>
  
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="data_referencia" class="block text-gray-700">Data de Referência</label>
          <input
            type="date"
            v-model="form.data_referencia"
            id="data_referencia"
            class="w-full p-2 border rounded mt-1"
          />
        </div>
  
        <div class="mb-4">
          <label for="uf" class="block text-gray-700">Unidade da Federação</label>
          <select
            v-model="form.uf"
            id="uf"
            class="w-full p-2 border rounded mt-1"
          >
            <option value="">Selecione</option>
            <option v-for="uf in ufs" :key="uf" :value="uf">{{ uf.nome }}</option>
          </select>
        </div>
  
        <div class="mb-4">
          <label for="rodovia" class="block text-gray-700">Rodovia</label>
          <select
            v-model="form.rodovia"
            id="rodovia"
            class="w-full p-2 border rounded mt-1"
          >
            <option value="">Selecione</option>
            <option v-for="rodovia in rodovias" :key="rodovia" :value="rodovia">BR-{{ rodovia.br }}</option>
          </select>
        </div>
  
        <div class="mb-4">
          <label for="tipo" class="block text-gray-700">Tipo do Trecho</label>
          <select
            v-model="form.tipo"
            id="tipo"
            class="w-full p-2 border rounded mt-1"
          >
            <option value="">Selecione</option>
            <option value="B">B</option>
            <option value="U">U</option>
          </select>
        </div>
  
        <div class="mb-4">
          <label for="km_inicial" class="block text-gray-700">Quilometragem Inicial</label>
          <input
            type="number"
            v-model="form.km_inicial"
            id="km_inicial"
            class="w-full p-2 border rounded mt-1"
          />
        </div>
  
        <div class="mb-4">
          <label for="km_final" class="block text-gray-700">Quilometragem Final</label>
          <input
            type="number"
            v-model="form.km_final"
            id="km_final"
            class="w-full p-2 border rounded mt-1"
          />
        </div>
  
        <button
          type="submit"
          class="bg-blue-500 text-white p-2 rounded"
        >
          Enviar
        </button>
      </form>
  
      <div v-if="successMessage" class="mt-4 p-2 bg-green-500 text-white">
        @{{ successMessage }}
      </div>
    </div>
    <div id="map">
        
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        form: {
          data_referencia: "",
          uf: "", 
          rodovia: "", 
          tipo: "",
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
      async submitForm() {
        try {
          const { data_referencia, uf, rodovia, tipo, km_inicial, km_final } = this.form;
  
            const apiUrl = '/geojson';
            const geoResponse = await axios.get(apiUrl, {
            params: {
                rodovia: rodovia.br, 
                tipo: tipo,
                uf: uf.sigla,
                data_referencia: data_referencia,
                km_inicial: km_inicial,
                km_final: km_final,
            },
            });
            console.log(geoResponse.data);
            const geo = geoResponse.data;

  
         const response = await axios.post("/trechos", {
            data_referencia,
            uf_id: uf.id, 
            rodovia_id: rodovia.id, 
            tipo,
            km_inicial,
            km_final,
            geo,
          });

          const createdTrechoId = response.data.trecho.id;

          window.location.href = `/detalhes/${createdTrechoId}`;
  
          this.successMessage = "Trecho salvo com sucesso!";
          this.form = {
            data_referencia: "",
            uf: "",
            rodovia: "",
            tipo: "",
            km_inicial: "",
            km_final: "",
          };
        } catch (error) {
          console.error(error);
          alert("Erro ao salvar o trecho. Verifique os dados e tente novamente.");
        }
      },
    },
  };

  </script>
  
  
  <style scoped>
  
  </style>
  