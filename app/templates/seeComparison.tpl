{extends 'layout.tpl'}
{block name=content}
    <div class="row">
        {foreach $alunos as $index => $aluno}
            <div class="col-xs-12 col-md-6">
                <h5 class="text-center">{$aluno->getNome()}</h5>
                <p class="text-center">IRA: {number_format($aluno->getIra(), 2)}

                <canvas class="mt-4" id="radar-{$index}"></canvas>
            </div>
        {/foreach}
    </div>


{/block}

{block name=javascript}
    <script>
        /***************************************
         * **************RADAR CHART**********
         ***************************************/
        for(var i = 0; i<=1; i++) {
            var grupos = []
            var gruposTotal = []
            var gruposLogado = []
            var nomeGrupos = []
            var valorGrupos = []
            var valorGruposTodos = []
            var valorGruposUsuarioLogado = []

            var numeroRadar = 0

            if (i === 0) {
                grupos = {json_encode($grupoAlunos[0])}
            } else {
                grupos = {json_encode($grupoAlunos[1])}
            }

            for (let grupo in grupos) {
                nomeGrupos.push(grupo)
                valorGrupos.push(grupos[grupo])
                valorGruposTodos.push(gruposTotal[grupo])
                valorGruposUsuarioLogado.push(gruposLogado[grupo])
            }


            var radar = document.getElementById('radar-' + i).getContext('2d');

            var opcoes = {
                legend: {
                    onClick: function (e) {
                        e.stopPropagation();
                    },
                    display: false,
                    labels: {
                        boxWidth: 0
                    }
                },
                tooltips: {
                    displayColors: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toFixed(2);
                        }
                    }
                },
                scale: {
                    ticks: {
                        beginAtZero: true,
                        max: 100,
                        min: 0,
                        stepSize: 20,
                        backdropColor: '#fafafa',
                        callback: function (value, index, values) {
                            if (index === 1) {
                                return "<" + value
                            }
                            return value
                        }
                    },
                }
            }

            var radarChart = new Chart(radar, {
                type: 'radar',
                data: {
                    labels: nomeGrupos,
                    datasets: [
                        {
                            backgroundColor: "rgba(41, 128, 185, 0.5)",
                            borderColor: "rgba(41, 128, 185, 0.8)",
                            lineTension: 0.02,
                            data: valorGrupos,
                        },
                    ]
                },
                options: opcoes
            })
        }
    </script>
{/block}