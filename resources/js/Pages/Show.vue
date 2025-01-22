<template>
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-7">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalhes do Trecho</h1>

    <div class="space-y-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="flex flex-col">
          <label for="data_referencia" class="text-gray-700 font-medium">Data de Referência</label>
          <span class="text-gray-800 text-lg">{{ trecho.data_referencia }}</span>
        </div>
        <div class="flex flex-col">
          <label for="tipo_trecho" class="text-gray-700 font-medium">Tipo de Trecho</label>
          <span class="text-gray-800 text-lg capitalize">{{ trecho.tipo }}</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="flex flex-col">
          <label for="uf" class="text-gray-700 font-medium">Unidade da Federação</label>
          <span class="text-gray-800 text-lg">{{ trecho.uf.nome }}</span>
        </div>
        <div class="flex flex-col">
          <label for="rodovia" class="text-gray-700 font-medium">Rodovia</label>
          <span class="text-gray-800 text-lg">BR-{{ trecho.rodovia.br }}</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="flex flex-col">
          <label for="km_inicial" class="text-gray-700 font-medium">Quilometragem Inicial</label>
          <span class="text-gray-800 text-lg">{{ trecho.km_inicial }} km</span>
        </div>
        <div class="flex flex-col">
          <label for="km_final" class="text-gray-700 font-medium">Quilometragem Final</label>
          <span class="text-gray-800 text-lg">{{ trecho.km_final }} km</span>
        </div>
      </div>

      <div class="flex flex-col">
        <label for="geo" class="text-gray-700 font-medium">GeoJSON</label>
        <div id="map" class="w-full h-96"></div>
      </div>
    </div>

    <div class="mt-6 text-center">
      <a
        href="/"
        class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600"
      >
        Voltar para a lista
      </a>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import L from "leaflet";

export default {
  data() {
    return {
      trecho: {
        data_referencia: "",
        tipo_trecho: "",
        uf: { nome: "" },
        rodovia: { br: "" },
        km_inicial: "",
        km_final: "",
        geo: {},
      },
    };
  },
  mounted() {
    this.fetchTrechoDetails();
  },
  methods: {
    async fetchTrechoDetails() {
      try {
        const id = window.location.pathname.split("/").pop();
        const response = await axios.get(`/trechos/${id}`);
        this.trecho = response.data;

        if (this.trecho.geo && Object.keys(this.trecho.geo).length > 0) {
          this.initializeMap(this.trecho.geo);
        }
      } catch (error) {
        console.error("Erro ao buscar os detalhes do trecho:", error);
        alert("Erro ao carregar os dados do trecho.");
      }
    },

    initializeMap(geoJson) {
      const map = L.map("map").setView([0, 0], 13);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
      const geoLayer = L.geoJSON(geoJson).addTo(map);
      const bounds = geoLayer.getBounds();
      map.fitBounds(bounds);
    },
  },
};
</script>

<style scoped>
#map {
  width: 100%;
  height: 400px;
  border-radius: 8px;
}
</style>
