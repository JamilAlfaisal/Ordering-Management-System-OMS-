<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fafafa;
      margin: 0;
      padding: 0;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background: white;
      border-bottom: 1px solid #ddd;
    }

    header h1 {
      display: flex;
      align-items: center;
      font-size: 20px;
      font-weight: bold;
      margin: 0;
    }

    header h1 span {
      margin-left: 10px;
    }

    .btn {
      padding: 10px 18px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-size: 14px;
      font-weight: bold;
    }

    .refresh {
      background: #ffb347;
      color: white;
    }

    .signout {
      background: #eee;
    }

    h2 {
      margin: 40px;
      font-size: 32px;
    }

    table {
      margin: 0 40px 60px 40px;
      width: calc(100% - 80px);
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 18px;
      text-align: left;
      border-bottom: 1px solid #eee;
      font-size: 14px;
    }

    th {
      background: #f7f7f7;
      font-weight: bold;
    }

    .status {
      padding: 8px 12px;
      border-radius: 8px;
      display: inline-block;
      font-size: 13px;
      font-weight: bold;
      color: #444;
      background: #f1e9e4;
    }

    .inprocess {
      background: #eae4dc;
    }

    .action {
      color: #8a4f30;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>★ <span>Artisan Bakery OMS</span></h1>
    <div>
      <button class="btn refresh">Refresh Orders</button>
      <button class="btn signout">Sign Out</button>
    </div>
  </header>

  <h2>Order Dashboard</h2>

  <table>
    <tr>
      <th>Order Number</th>
      <th>Customer Name</th>
      <th>Items Ordered</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>

    <tr>
      <td>#1001</td>
      <td>Sophia Clark</td>
      <td>2× Croissants, 1× Baguette</td>
      <td><span class="status">Pending</span></td>
      <td class="action">Mark as In Process</td>
    </tr>
  </table>
</body>
</html>
