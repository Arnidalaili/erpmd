<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AclController;
use App\Http\Controllers\UserAclController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogTrailController;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\GroupProductController;
use App\Http\Controllers\ArmadaController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\PerkiraanController;
use App\Http\Controllers\AlatBayarController;
use App\Http\Controllers\CekPesananController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GroupCustomerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\FakturPembelianDetailController;
use App\Http\Controllers\FakturPembelianHeaderController;
use App\Http\Controllers\PelunasanHutangDetailController;
use App\Http\Controllers\PelunasanHutangHeaderController;
use App\Http\Controllers\PelunasanPiutangDetailController;
use App\Http\Controllers\PelunasanPiutangHeaderController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PesananDetailController;
use App\Http\Controllers\PesananFinalHeaderController;
use App\Http\Controllers\PembelianHeaderController;
use App\Http\Controllers\TransaksiBelanjaController;
use App\Http\Controllers\TransaksiArmadaController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PenjualanHeaderController;
use App\Http\Controllers\PesananHeaderController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReturBeliDetailController;
use App\Http\Controllers\ReturBeliHeaderController;
use App\Http\Controllers\ReturJualDetailController;
use App\Http\Controllers\ReturJualHeaderController;
use App\Http\Controllers\HPPController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\PenyesuaianStokHeaderController;
use App\Http\Controllers\UbahPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::middleware('guest')->group(function () {
//     Route::get('login/index', [AuthController::class, 'index'])->name('login');
//     Route::get('login', [AuthController::class, 'index'])->name('login');
//     Route::post('login', [AuthController::class, 'login'])->name('login.process');
// });

Route::get('cekip', [AuthController::class, 'cekIp']);
Route::get('cekparam', [AuthController::class, 'cek_param']);

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('login/index', [AuthController::class, 'index']);
    Route::post('login', [AuthController::class, 'login'])->name('login.process');
});

Route::get('reset-password/expired', [ResetPasswordController::class, 'expired'])->name('reset-password.expired');
Route::get('reset-password/success', [ResetPasswordController::class, 'success'])->name('reset-password.success');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password.index')->middleware('jwt');

Route::middleware(['auth'])->group(function () {
Route::post('/push', [PushController::class, 'store'])->name('push');
Route::post('/pushdapatnotif', [PushController::class, 'pushdapatnotif'])->name('pushdapatnotif');

});

Route::middleware(['auth','authorized'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('/');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('hpp/index', [HPPController::class, 'index']);
    Route::get('kartustok/index', [KartuStokController::class, 'index']);

    Route::get('parameter/field_length', [ParameterController::class, 'fieldLength'])->name('parameter.field_length');
    Route::get('parameter/{id}/delete', [ParameterController::class, 'delete'])->name('parameter.delete');
    Route::get('parameter/index', [ParameterController::class, 'index']);
    Route::get('parameter/report', [ParameterController::class, 'report'])->name('parameter.report');
    Route::get('parameter/export', [ParameterController::class, 'export'])->name('parameter.export');
    Route::get('parameter/detail', [ParameterController::class, 'detail'])->name('parameter.detail');
    Route::get('parameter/get', [ParameterController::class, 'get'])->name('parameter.get');
    Route::resource('parameter', ParameterController::class);

    Route::get('error/field_length', [ErrorController::class, 'fieldLength'])->name('error.field_length');
    Route::get('error/{id}/delete', [ErrorController::class, 'delete'])->name('error.delete');
    Route::get('error/index', [ErrorController::class, 'index']);
    Route::get('error/get', [ErrorController::class, 'get'])->name('error.get');
    Route::get('error/export', [ErrorController::class, 'export'])->name('error.export');
    Route::get('error/report', [ErrorController::class, 'report'])->name('error.report');
    Route::resource('error', ErrorController::class);

    Route::get('cabang/field_length', [CabangController::class, 'fieldLength'])->name('cabang.field_length');
    Route::get('cabang/{id}/delete', [CabangController::class, 'delete'])->name('cabang.delete');
    Route::get('cabang/index', [CabangController::class, 'index']);
    Route::get('cabang/get', [CabangController::class, 'get'])->name('cabang.get');
    Route::get('cabang/export', [CabangController::class, 'export'])->name('cabang.export');
    Route::get('cabang/report', [CabangController::class, 'report'])->name('cabang.report');
    Route::resource('cabang', CabangController::class);

    Route::get('ubahpassword/index', [UbahPasswordController::class, 'index']);
    Route::resource('ubahpassword', UbahPasswordController::class);

    Route::get('role/field_length', [RoleController::class, 'fieldLength'])->name('role.field_length');
    Route::get('role/{id}/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('role/getroleid', [RoleController::class, 'getroleid']);
    Route::get('role/index', [RoleController::class, 'index']);
    Route::get('role/get', [RoleController::class, 'get'])->name('role.get');
    Route::get('role/acl/grid', [RoleController::class, 'aclGrid']);
    Route::get('role/export', [RoleController::class, 'export'])->name('role.export');
    Route::get('role/report', [RoleController::class, 'report'])->name('role.report');
    Route::resource('role', RoleController::class);

    Route::get('user/field_length', [UserController::class, 'fieldLength'])->name('user.field_length');
    Route::get('user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('user/getuserid', [UserController::class, 'getuserid']);
    Route::get('user/index', [UserController::class, 'index']);
    Route::get('user/get', [UserController::class, 'get'])->name('user.get');
    Route::get('user/export', [UserController::class, 'export'])->name('user.export');
    Route::get('user/report', [UserController::class, 'report'])->name('user.report');
    Route::get('user/acl/grid', [UserController::class, 'aclGrid']);
    Route::get('user/role/grid', [UserController::class, 'roleGrid']);
    Route::resource('user', UserController::class);

    Route::get('menu/field_length', [MenuController::class, 'fieldLength'])->name('menu.field_length');
    Route::get('menu/getdata', [MenuController::class, 'getdata'])->name('menu.getdata');
    Route::get('menu/{id}/delete', [MenuController::class, 'delete'])->name('menu.delete');
    Route::get('menu/listFolderFiles', [MenuController::class, 'listFolderFiles'])->name('menu.listFolderFiles');
    Route::get('menu/listclassall', [MenuController::class, 'listclassall'])->name('menu.listclassall');
    Route::get('menu/index', [MenuController::class, 'index']);
    Route::get('menu/get', [MenuController::class, 'get'])->name('menu.get');
    Route::get('menu/resequence', [MenuController::class, 'resequence'])->name('menu.resequence');
    Route::post('menu/resequence', [MenuController::class, 'storeResequence'])->name('menu.resequence.store');
    Route::get('menu/export', [MenuController::class, 'export'])->name('menu.export');
    Route::get('menu/report', [MenuController::class, 'report'])->name('menu.report');
    Route::resource('menu', MenuController::class);

    Route::get('userrole/{id}/delete', [UserRoleController::class, 'delete'])->name('userrole.delete');
    Route::get('userrole/field_length', [UserRoleController::class, 'fieldLength'])->name('userrole.field_length');
    Route::get('userrole/detail', [UserRoleController::class, 'detail'])->name('userrole.detail');
    Route::get('userrole/index', [UserRoleController::class, 'index']);
    Route::get('userrole/get', [UserRoleController::class, 'get'])->name('userrole.get');
    Route::get('userrole/export', [UserRoleController::class, 'export'])->name('userrole.export');
    Route::get('userrole/report', [UserRoleController::class, 'report'])->name('userrole.report');
    Route::resource('userrole', UserRoleController::class);

    Route::get('acl/{id}/delete', [AclController::class, 'delete'])->name('acl.delete');
    Route::get('acl/field_length', [AclController::class, 'fieldLength'])->name('acl.field_length');
    Route::get('acl/detail', [AclController::class, 'detail'])->name('acl.detail');
    Route::get('acl/index', [AclController::class, 'index']);
    Route::get('acl/export', [AclController::class, 'export'])->name('acl.export');
    Route::get('acl/report', [AclController::class, 'report'])->name('acl.report');
    Route::get('acl/get', [AclController::class, 'get'])->name('acl.get');
    Route::resource('acl', AclController::class);

    Route::get('useracl/{id}/delete', [UserAclController::class, 'delete'])->name('useracl.delete');
    Route::get('useracl/field_length', [UserAclController::class, 'fieldLength'])->name('useracl.field_length');
    Route::get('useracl/detail', [UserAclController::class, 'detail'])->name('useracl.detail');
    Route::get('useracl/report', [UserAclController::class, 'report'])->name('useracl.report');
    Route::get('useracl/export', [UserAclController::class, 'export'])->name('useracl.export');
    Route::get('useracl/index', [UserAclController::class, 'index']);
    Route::get('useracl/get', [UserAclController::class, 'get'])->name('useracl.get');

    Route::resource('useracl', UserAclController::class);

    Route::get('logtrail/index', [LogTrailController::class, 'index']);
    Route::get('logtrail/get', [LogTrailController::class, 'get'])->name('logtrail.get');
    Route::get('logtrail/report', [LogTrailController::class, 'report'])->name('logtrail.report');
    Route::get('logtrail/export', [LogTrailController::class, 'export'])->name('logtrail.export');
    Route::get('logtrail/header', [LogTrailController::class, 'header'])->name('logtrail.header');
    Route::get('logtrail/detail', [LogTrailController::class, 'detail'])->name('logtrail.detail');
    Route::resource('logtrail', LogTrailController::class);

    Route::get('harilibur/get', [HariLiburController::class, 'get'])->name('harilibur.get');
    Route::get('harilibur/export', [HariLiburController::class, 'export'])->name('harilibur.export');
    Route::get('harilibur/report', [HariLiburController::class, 'report'])->name('harilibur.report');
    Route::get('harilibur/index', [HariLiburController::class, 'index']);
    Route::resource('harilibur', HariLiburController::class);

    Route::get('pesananheader/index', [PesananHeaderController::class, 'index'])->name('pesananheader.index');
    Route::get('pesananheader/report', [PesananHeaderController::class, 'report'])->name('pesananheader.report');
    Route::resource('pesananheader', PesananHeaderController::class);
    Route::resource('pesanandetail', PesananDetailController::class);

    Route::get('pesananfinalheader/index', [PesananFinalHeaderController::class, 'index']);
    Route::get('pesananfinalheader/export', [PesananFinalHeaderController::class, 'export'])->name('pesananfinalheader.export');
    Route::get('pesananfinalheader/report', [PesananFinalHeaderController::class, 'report'])->name('pesananfinalheader.report');
    Route::get('pesananfinalheader/reportpembelian', [PesananFinalHeaderController::class, 'reportPembelian'])->name('pesananfinalheader.reportpembelian');
    Route::get('pesananfinalheader/reportpembelianall', [PesananFinalHeaderController::class, 'reportPembelianAll'])->name('pesananfinalheader.reportpembelianall');
    Route::resource('pesananfinalheader', PesananFinalHeaderController::class);
    Route::resource('pesananfinaldetail', PesananDetailController::class);

    Route::get('cekpesanan/index', [CekPesananController::class, 'index'])->name('cekpesanan.index');
    Route::resource('cekpesanan', CekPesananController::class);

    Route::get('pembelianheader/index', [PembelianHeaderController::class, 'index']);
    Route::get('pembelianheader/export', [PembelianHeaderController::class, 'export'])->name('pembelianheader.export');
    Route::get('pembelianheader/report', [PembelianHeaderController::class, 'report'])->name('pembelianheader.report');
    Route::resource('pembelianheader', PembelianHeaderController::class);
    Route::resource('pembeliandetail', PembelianDetailController::class);

    Route::get('penjualanheader/index', [PenjualanHeaderController::class, 'index']);
    Route::get('penjualanheader/export', [PenjualanHeaderController::class, 'export'])->name('penjualanheader.export');
    Route::get('penjualanheader/invoice', [PenjualanHeaderController::class, 'invoice'])->name('penjualanheader.invoice');
    Route::resource('penjualanheader', PenjualanHeaderController::class);
    Route::resource('penjualandetail', PenjualanDetailController::class);

    Route::get('returjualheader/index', [ReturJualHeaderController::class, 'index']);
    Route::get('returjualheader/export', [ReturJualHeaderController::class, 'export'])->name('returjualheader.export');
    Route::get('returjualheader/report', [ReturJualHeaderController::class, 'report'])->name('returjualheader.report');
    Route::resource('returjualheader', ReturJualHeaderController::class);
    Route::resource('returjualdetail', ReturJualDetailController::class);

    Route::get('returbeliheader/index', [ReturBeliHeaderController::class, 'index']);
    Route::get('returbeliheader/export', [ReturBeliHeaderController::class, 'export'])->name('returbeliheader.export');
    Route::get('returbeliheader/report', [ReturBeliHeaderController::class, 'report'])->name('returbeliheader.report');
    Route::resource('returbeliheader', ReturBeliHeaderController::class);
    Route::resource('returbelidetail', ReturBeliDetailController::class);

    Route::get('transaksibelanja/index', [TransaksiBelanjaController::class, 'index']);
    Route::get('transaksibelanja/export', [TransaksiBelanjaController::class, 'export'])->name('transaksibelanja.export');
    Route::get('transaksibelanja/report', [TransaksiBelanjaController::class, 'report'])->name('transaksibelanja.report');
    Route::resource('transaksibelanja', TransaksiBelanjaController::class);

    Route::get('transaksiarmada/index', [TransaksiArmadaController::class, 'index']);
    Route::get('transaksiarmada/export', [TransaksiArmadaController::class, 'export'])->name('transaksiarmada.export');
    Route::get('transaksiarmada/report', [TransaksiArmadaController::class, 'report'])->name('transaksiarmada.report');
    Route::resource('transaksiarmada', TransaksiArmadaController::class);

    Route::get('pelunasanhutangheader/index', [PelunasanHutangHeaderController::class, 'index']);
    Route::get('pelunasanhutangdetail/index', [PelunasanHutangHeaderController::class, 'index']);
    Route::resource('pelunasanhutangheader', PelunasanHutangHeaderController::class);
    Route::resource('pelunasanhutangdetail', PelunasanHutangDetailController::class);

    Route::get('pelunasanpiutangheader/index', [PelunasanPiutangHeaderController::class, 'index']);
    Route::get('pelunasanpiutangdetail/index', [PelunasanPiutangHeaderController::class, 'index']);
    Route::resource('pelunasanpiutangheader', PelunasanHutangHeaderController::class);
    Route::resource('pelunasanpiutangdetail', PelunasanPiutangDetailController::class);

    Route::get('fakturpembelianheader/index', [FakturPembelianHeaderController::class, 'index']);
    Route::resource('fakturpembelianheader', FakturPembelianHeaderController::class);
    Route::resource('fakturpembeliandetail', FakturPembelianDetailController::class);
    Route::resource('fakturpenjualandetail', FakturPenjualanDetailController::class);

    Route::get('owner/get', [OwnerController::class, 'get'])->name('owner.get');
    Route::get('owner/export', [OwnerController::class, 'export'])->name('owner.export');
    Route::get('owner/report', [OwnerController::class, 'report'])->name('owner.report');
    Route::get('owner/index', [OwnerController::class, 'index']);
    Route::resource('owner', OwnerController::class);

    Route::get('satuan/get', [SatuanController::class, 'get'])->name('satuan.get');
    Route::get('satuan/export', [SatuanController::class, 'export'])->name('satuan.export');
    Route::get('satuan/report', [SatuanController::class, 'report'])->name('satuan.report');
    Route::get('satuan/index', [SatuanController::class, 'index']);
    Route::resource('satuan', SatuanController::class);

    Route::get('groupproduct/get', [GroupProductController::class, 'get'])->name('groupproduct.get');
    Route::get('groupproduct/export', [GroupProductController::class, 'export'])->name('groupproduct.export');
    Route::get('groupproduct/report', [GroupProductController::class, 'report'])->name('groupproduct.report');
    Route::get('groupproduct/index', [GroupProductController::class, 'index']);
    Route::resource('groupproduct', GroupProductController::class);

    Route::get('armada/get', [ArmadaController::class, 'get'])->name('armada.get');
    Route::get('armada/export', [ArmadaController::class, 'export'])->name('armada.export');
    Route::get('armada/report', [ArmadaController::class, 'report'])->name('armada.report');
    Route::get('armada/index', [ArmadaController::class, 'index']);
    Route::resource('armada', ArmadaController::class);

    Route::get('karyawan/get', [KaryawanController::class, 'get'])->name('karyawan.get');
    Route::get('karyawan/export', [KaryawanController::class, 'export'])->name('karyawan.export');
    Route::get('karyawan/report', [KaryawanController::class, 'report'])->name('karyawan.report');
    Route::get('karyawan/index', [KaryawanController::class, 'index']);
    Route::resource('karyawan', KaryawanController::class);

    Route::get('bank/get', [BankController::class, 'get'])->name('bank.get');
    Route::get('bank/export', [BankController::class, 'export'])->name('bank.export');
    Route::get('bank/report', [BankController::class, 'report'])->name('bank.report');
    Route::get('bank/index', [BankController::class, 'index']);
    Route::resource('bank', BankController::class);

    Route::get('perkiraan/get', [PerkiraanController::class, 'get'])->name('perkiraan.get');
    Route::get('perkiraan/export', [PerkiraanController::class, 'export'])->name('perkiraan.export');
    Route::get('perkiraan/report', [PerkiraanController::class, 'report'])->name('perkiraan.report');
    Route::get('perkiraan/index', [PerkiraanController::class, 'index']);
    Route::resource('perkiraan', PerkiraanController::class);

    Route::get('alatbayar/get', [AlatBayarController::class, 'get'])->name('alatbayar.get');
    Route::get('alatbayar/export', [AlatBayarController::class, 'export'])->name('alatbayar.export');
    Route::get('alatbayar/report', [AlatBayarController::class, 'report'])->name('alatbayar.report');
    Route::get('alatbayar/index', [AlatBayarController::class, 'index']);
    Route::resource('alatbayar', AlatBayarController::class);

    Route::get('supplier/get', [SupplierController::class, 'get'])->name('supplier.get');
    Route::get('supplier/export', [SupplierController::class, 'export'])->name('supplier.export');
    Route::get('supplier/report', [SupplierController::class, 'report'])->name('supplier.report');
    Route::get('supplier/index', [SupplierController::class, 'index']);
    Route::resource('supplier', SupplierController::class);

    Route::get('groupcustomer/get', [GroupCustomerController::class, 'get'])->name('groupcustomer.get');
    Route::get('groupcustomer/export', [GroupCustomerController::class, 'export'])->name('groupcustomer.export');
    Route::get('groupcustomer/report', [GroupCustomerController::class, 'report'])->name('groupcustomer.report');
    Route::get('groupcustomer/index', [GroupCustomerController::class, 'index']);
    Route::resource('groupcustomer', GroupCustomerController::class);

    Route::get('customer/get', [CustomerController::class, 'get'])->name('customer.get');
    Route::get('customer/export', [CustomerController::class, 'export'])->name('customer.export');
    Route::get('customer/report', [CustomerController::class, 'report'])->name('customer.report');
    Route::get('customer/index', [CustomerController::class, 'index']);
    Route::resource('customer', CustomerController::class);

    Route::get('product/get', [ProductController::class, 'get'])->name('product.get');
    Route::get('product/export', [ProductController::class, 'export'])->name('product.export');
    Route::get('product/report', [ProductController::class, 'report'])->name('product.report');
    Route::get('product/index', [ProductController::class, 'index']);
    Route::resource('product', ProductController::class);

    Route::get('hutang/get', [HutangController::class, 'get'])->name('hutang.get');
    Route::get('hutang/export', [HutangController::class, 'export'])->name('hutang.export');
    Route::get('hutang/report', [HutangController::class, 'report'])->name('hutang.report');
    Route::get('hutang/index', [HutangController::class, 'index']);
    Route::resource('hutang', HutangController::class);

    Route::get('piutang/get', [PiutangController::class, 'get'])->name('piutang.get');
    Route::get('piutang/export', [PiutangController::class, 'export'])->name('piutang.export');
    Route::get('piutang/report', [PiutangController::class, 'report'])->name('piutang.report');
    Route::get('piutang/index', [PiutangController::class, 'index']);
    Route::resource('piutang', PiutangController::class);

    Route::get('penyesuaianstokheader/get', [PenyesuaianStokHeaderController::class, 'get'])->name('penyesuaianstokheader.get');
    Route::get('penyesuaianstokheader/export', [PenyesuaianStokHeaderController::class, 'export'])->name('penyesuaianstokheader.export');
    Route::get('penyesuaianstokheader/report', [PenyesuaianStokHeaderController::class, 'report'])->name('penyesuaianstokheader.report');
    Route::get('penyesuaianstokheader/index', [PenyesuaianStokHeaderController::class, 'index']);
    Route::resource('penyesuaianstokheader', PenyesuaianStokHeaderController::class);
});

Route::patch('format', [FormatController::class, 'update']);
Route::get('lookup/{fileName}', [LookupController::class, 'show']);