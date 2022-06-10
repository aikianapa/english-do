<html>

<div class="p-2">
  <form id="repMonth">
    <input type="month" name="month" value="{{_post.formdata.month}}" class="form-control"
      data-ajax="{'url':'/cms/ajax/form/visits/rep_month/','form':'#repMonth','html':'.content-body'}"
    />
  </form>
  <table class="tx-14 table table-bordered table-hover table-sm table-striped table-responsive">
    <thead>
      <tr>
        <th class="p-1">
          #
        </th>
        <th class="p-1">
          Student
        </th>

        <wb-foreach wb="from=days">
          <th class="p-1 text-center">
            {{_ndx}}
          </th>
        </wb-foreach>
      </tr>
    </thead>
    <tbody>
      <wb-var month="{{month}}" />
      <wb-foreach wb="from=rep">
        <tr>
          <td class='tx-12 p-1'>
            {{_ndx}}
          </td>
          <td class='tx-12 p-1 tx-bold'>
            <wb-data wb="table=users&item={{_key}}">
              {{last_name}} {{first_name}}
            </wb-data>
          </td>
          <wb-foreach wb="from=_parent.days">
            <td class="p-1">
              <wb-var date="{{_var.month}}-{{_val}}" />
              <wb-var check="1" wb-if="in_array('{{_var.date}}',{{_parent._val}})" else="0" />
              <i class="ri-check-fill tx-success tx-16 tx-bold" title="{{_var.date}}" wb-if="'{{_var.check}}'=='1'"  ></i>
              <i class="ri-close-line tx-gray-200 tx-16" title="{{_var.date}}" wb-if="'{{_var.check}}'=='0'"  ></i>
            </td>
          </wb-foreach>
        </tr>
      </wb-foreach>
    </tbody>
  </table>
</div>

</html>
