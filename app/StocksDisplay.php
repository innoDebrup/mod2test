<tr>
  <td><?= $stock['stock_name'] ?></td>
  <td><?= $stock['stock_price'] ?></td>
  <td><?= $stock['user_name'] ?></td>
  <td><?= $stock['time_created'] ?></td>
  <td><?= $stock['time_edited'] ?></td>
  <?php if ($stock['user_id'] == $_SESSION['user_id']):?>
    <td>
      <form action="/home" method="post">
        <input type="text" name='op' value="remove" hidden>
        <input type="number" name='s_id' value="<?= $stock['s_id']?>" hidden>
        <input type="number" name="u_id" value="<?= $stock['user_id']?>" hidden>
        <input type="submit" value="Remove">
      </form>
    </td>
  <?php endif ?>
</tr>
