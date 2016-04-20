<table border="1">
	<thead>
		<tr>
			<th>Leveranciersnummer</th>
			<th>Bedrijfsnaam</th>
			<th>Adres</th>
			<th>Postcode</th>
			<th>Plaats</th>
			<th>Telefoonnummer</th>
			<th>Email</th>
			
		</tr>
	</thead>
	<tbody>
		<?php
			$servername = "";
			$username = "";
			$password = "";
			try {
				//Creating connection for mysql
				$db = new PDO("mysql:host=$servername;dbname=DB2538415", $username, $password);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query = $db->prepare("SELECT * FROM cart_leverancier");
				if ($query->execute()){
					$tabel = $query->fetchAll(PDO::FETCH_ASSOC);
					foreach ($tabel as $row) {
						echo "<tr>";
						foreach ($row as $column) {
							echo "<td>";
							print_r($column);
							echo "</td>";
						}
						echo "</tr>";
					}
				}
			}catch(PDOException $e){
				echo "<div class=\"alert alert-danger\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Fout!</strong> ".$e->getMessage()."</div>";
			}
		?>
	</tbody>
</table>