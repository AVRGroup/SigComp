{extends 'layout.tpl'}
{block name=content}
    <canvas class="mt-4" id="radar"></canvas>

    <div class="text-center">
        <button class="btn btn-primary" onclick="setDisciplinasRelizadas()">Disciplinas já Realizadas</button>
        <button class="btn btn-success" onclick="setTodasDisciplinas()">Todas as disciplinas</button>
    </div>

    <div class="row mt-5">
        {foreach $alunos as $index => $aluno}
            <div class="col-sm-2">
                <span class="cor-aluno-comparacao" id="cor-{$index}"></span>
                <p>{$aluno->getNome()}</p>
            </div>
        {/foreach}
    </div>

    <div class="mt-4">
        <b>Maior Ira:</b>
        <p>{$maiorIra->getNome()}: {number_format($maiorIra->getIra(), 2)}</p>
    </div>

    <b>Top alunos por Grupo (relativo às disciplinas já relizadas):</b>
    <div class="row mt-4">
        {foreach $maiorAlunoPorGrupo as $grupo => $aluno}
            <div class="col-4">
                <b>{$grupo}</b>
                <p>{$alunos[$aluno]->getNome()}: {number_format($grupoAlunos[$aluno][$grupo], 2)}</p>
            </div>
        {/foreach}
    </div>
{/block}

{block name=javascript}
    <script>
        /***************************************
         * **************RADAR CHART**********
         ***************************************/

        const todosGrupos = JSON.parse('{json_encode($grupoAlunos)}')
        const todosGruposTotal = JSON.parse('{json_encode($grupoAlunosTotal)}')
        var nomeGrupos = []

        const backgroundColors = ["rgba(46, 204, 113,0.5)", "rgba(52, 152, 219,0.5)", 'rgba(155, 89, 182,0.5)', 'rgba(243, 156, 18,0.5)', 'rgba(231, 76, 60,0.5)']
        const borderColors = ["rgba(46, 204, 113,0.8)", "rgba(52, 152, 219,0.8)", 'rgba(155, 89, 182,0.8)', 'rgba(243, 156, 18,0.8)', 'rgba(231, 76, 60,0.8)']

        for (var nome in todosGrupos[0]) {
            nomeGrupos.push(nome)
        }

        var datasets = []
        var datasetsTotal = []
        var i = 0

        for(var aluno of todosGrupos) {
            var data = []

            for (var grupo in aluno) {
                data.push(aluno[grupo])
            }

            datasets.push({
                backgroundColor: backgroundColors[i],
                borderColor: borderColors[i],
                lineTension: 0.02,
                data: data
            })

            document.getElementById('cor-' + i).style.backgroundColor = borderColors[i]

            i++
        }

        i = 0
        for (var aluno of todosGruposTotal) {
            var dataTotal = []

            for (var grupo in aluno) {
                dataTotal.push(aluno[grupo])
            }

            datasetsTotal.push({
                backgroundColor: backgroundColors[i],
                borderColor: borderColors[i],
                lineTension: 0.02,
                data: dataTotal
            })
            i++
        }

        var radar = document.getElementById('radar').getContext('2d');

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
                datasets: datasets
            },
            options: opcoes
        })

        function setTodasDisciplinas() {
            radarChart.data.datasets = datasetsTotal
            radarChart.update()
        }

        function setDisciplinasRelizadas() {
            radarChart.data.datasets = datasets
            radarChart.update()
        }

    </script>
{/block}