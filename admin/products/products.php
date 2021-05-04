            <?php
            include_once('../header.php');

            // DB 연결
            $conn = mysqli_connect("127.0.0.1", "root", "vision9292!", "primo");
            if (!$conn) {
                echo 'db에 연결하지 못했습니다.' . mysqli_connect_error();
                die();
            }

            $sql = "SELECT * FROM item";
            $result = mysqli_query($conn, $sql);
            ?>

            <main>
                <div class="main_title">
                    <div>
                        <h1>제품</h1>
                    </div>
                    <div>
                        <a href="add.php">제품 추가</a>
                    </div>
                </div>
                <div>
                    <table id="example-table-1" class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>
                                    <input type="checkbox">
                                </th>
                                <th>사진</th>
                                <th>제품</th>
                                <th>상태</th>
                                <th>재고</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $itemId = $row['id'];
                                $itemSchool = $row['school'];
                                $itemName = $row['name'];
                                $itemSex = $row['sex'];
                                $itemPrice = $row['price'];
                                $itemImage = $row['image'];
                                $name = "$itemSchool $itemName";

                                // 총 재고 구한다.
                                $sql = "SELECT SUM(quantity) FROM product WHERE item_id = $itemId";
                                $result2 = mysqli_query($conn, $sql);
                                if ($result2) {
                                    $row2 = mysqli_fetch_array($result2);
                                    $qantity = $row2[0];
                                }
                            ?>
                                <tr>
                                    <td hidden>
                                        <?= $itemId ?>
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                    <td>
                                        <img src="../../assets/img/gallery/market/<?= "$itemImage" ?>" height="60px">
                                    </td>
                                    <td><?= $name ?></td>
                                    <td>발주</td>
                                    <td><?= $qantity ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>

            <script>
                $("#example-table-1 tr").click(function() {
                    var tr = $(this);
                    var td = tr.children();

                    var id = td.eq(0).text();

                    var path = "update.php";
                    var params = {
                        'item_id': id
                    };
                    var method = "post";

                    var form = document.createElement("form");
                    form.setAttribute("method", method);
                    form.setAttribute("action", path);

                    for (var key in params) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", key);
                        hiddenField.setAttribute("value", params[key]);
                        form.appendChild(hiddenField);
                    }
                    document.body.appendChild(form);
                    form.submit();
                });
            </script>

            <?php
            include_once('../footer.php');
            ?>