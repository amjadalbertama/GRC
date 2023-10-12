function genPol(id_bizenv) {
    $(this).prop("disabled", true)
    $(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
    )
    $.LoadingOverlay("show")
    
    var token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: baseurl + "/api/v1/policies/generate",
        type: "POST",
        data: {
            id_bizenv: id_bizenv,
        },
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $.LoadingOverlay("hide")
                $("#genPolicyButtonDetail" + id_bizenv).replaceWith('<a id="policyGeneratedDetail' + id_bizenv + '" href="" class="btn btn-sm btn-outline-secondary border mt-2" title="Policy Generated"><i class="fa fa-check mr-2"></i>Policy Generated - ID: ' + result.data.id + '</a>');
                toastr.success(result.message, "Policy Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(result.message, "Policy Error");
            }
        }
    });
}

function setToInputKpi(id_pol) {
    var id_policy = $("#idPol").val(id_pol);
}

$(document).ready(function() {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var token = $('meta[name="csrf-token"]').attr('content');

    $("#addType").click(function() {
        $.LoadingOverlay("show")
        var indicators = $("#indicators").val();
        var metric = $("#metric").val();
        var percentage = $("#percentage").val();
        var period = $("#period").val();
        var idPol = $("#idPol").val();

        var j = $("#subTotalType" + idPol).text();
        var k = $("#subTotalTypeKpiEdit" + idPol).val();
        var subTot = Number(j.replace(/[^0-9,-]+/g, ""));
        var total = parseFloat(k) + parseFloat(percentage);

        if (total <= 100) {
            $.ajax({
                url: baseurl + "/api/v1/policies/generate/kpi",
                type: "POST",
                data: {
                    indicators: indicators,
                    metric: metric,
                    percentage: percentage,
                    period: period,
                    id_policies: idPol,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $.LoadingOverlay("hide")
                        $("#subTotalType" + idPol).html(`` + total + `<input type="hidden" id="subTotalTypeKpiEdit` + idPol + `" value="` + total + `">`);
                        $("#subTotalTypeKpiEdit" + idPol).val(total);
                        var tblHtml = `
                        <tr class="">
                            <td class="kpiText w-250px pr-5">
                                <div class="text-truncate w-250px" title="title">` + result.data.indicators + `</div>
                            </td>
                            <td class="metricText text-left">` + result.data.metric + `</td>
                            <td class="periodText text-center">` + result.data.period + `</td>
                            <td class="percentText text-right">` + result.data.percentage + `</td>
                            <td class="text-center"><a id="delBtn` + result.data.id + `" class="delBtn" role="button" onclick="delKpi(` + result.data.id + `, ` + idPol + `)"><i class="fa fa-times"></i></td>
                        </tr>
                        `;
                        $("#indicators").val("");
                        $("#metric").val("");
                        $("#percentage").val("");
                        $("#period").val("");
                        $("#idPol").val("");
                        $(tblHtml).appendTo("#customTable" + idPol);
                        toastr.success(result.message, "Policy Success");
                    } else {
                        $.LoadingOverlay("hide")
                        toastr.error(result.message, "Policy Error");
                    }
                }
            });
        } else {
            $.LoadingOverlay("hide")
            toastr.error("Hasil persen tidak boleh lebih dari 100!", "Policy Error");
        }
    });

    var ocSmart = `1 - Specific\n2 - Measurable\n3 - Achevable\n4 - Relevant\n5 - Time Bound`
    $(".object_criteria").html(ocSmart)
});

function delKpi(id_pol_kpi, idPol) {
    $.LoadingOverlay("show")
    var volumeDel = $("#delBtn" + id_pol_kpi).closest('tr').find($(".percentText")).text();
    var k = $("#subTotalTypeKpiEdit" + idPol).val();
    if (confirm("Hapus data ini?")) {
        axios.delete(baseurl + "/api/v1/del_kpi_policy/" + id_pol_kpi).then(function(response) {
            if (response.data.success) {
                $.LoadingOverlay("hide")
                $("#delBtn" + id_pol_kpi).closest('tr').remove();
                subTot = parseFloat(k) - parseFloat(volumeDel);
                $("#subTotalType" + idPol).html(`` + subTot + `<input type="hidden" id="subTotalTypeKpiEdit` + idPol + `" value="` + subTot + `">`);
                toastr.success(response.data.message, "KPI Objective Delete Success");
            } else {
                $.LoadingOverlay("hide")
                toastr.error(response.data.message, "KPI Objective Delete Error");
                return false
            }
        });
    } else {
        return false;
    }
}