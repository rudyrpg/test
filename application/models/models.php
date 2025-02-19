<?php
class Models extends CI_Model
{

    function save($table, $data)
    {
        $save = $this->db->insert($table, $data);
        if ($save) {
            return true;
        } else {
            return false;
        }
    }

    function fields($tbl)
    {
        return $this->db->list_fields($tbl);
    }

    function save_array($table, $data)
    {
        $save = $this->db->insert_batch($table, $data);
        if ($save) {
            return true;
        } else {
            return false;
        }
    }

    function check_data($condition, $table)
    {
        $this->db->where($condition);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function showdata($sql)
    {
        $results = array();
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    function showdata_monthly($sql)
    {
        $query = $this->db->query($sql)->result_array();
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    function showsingle($sql)
    {
        $query = $this->db->query($sql)->row();
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    function deletepermanent($kondisi, $table)
    {
        $this->db->where($kondisi);
        $this->db->delete($table);
    }

    function update($kondisi, $table, $data)
    {
        $this->db->where($kondisi);
        $this->db->update($table, $data);
    }

    function queryhandle($query)
    {
        $this->db->query($query);
    }

    //  ------------------------------------------------------------------------Delivery Receipt---------------------------------------//
    function create_no_trans($TransactionType = '', $NoTransactionType = '', $category = '', $cstseries = '', $tocustomer = '')
    {

        $ThBl         = $this->showsingle("SELECT SerieCode AS Code FROM NoSeriesOnYear With(NoLock) Where YearNo = YEAR(getdate())");
        $NewThB1    = $this->showsingle("SELECT '" . $ThBl->Code . "' + SerieCode rslt FROM NoSeriesOnMonth With(NoLock) Where MonthNo = MONTH(getdate())");
        if ($NoTransactionType == "ILE") {
            $check = $this->showsingle("SELECT count(*) total FROM ItemLedgerEntry 
											where CustomerCode = '" . $tocustomer . "' And 
											TransactionNo like 'ILE-' + '" . $NewThB1->rslt . "' + '%'");
            if ($check->total == 0) {
                $newNextNo = 1;
            } else {
                $next        = $this->showsingle("SELECT 1 + Max(Cast(SUBSTRING (TransactionNo,patindex('%-[0-9]%',TransactionNo) + 1,
							len(TransactionNo)) as Numeric))
							as NextNo 
							from ItemLedgerEntry with(nolock)  
							where CustomerCode = '" . $tocustomer . "' And TransactionNo like 'ILE-' + '" . $NewThB1->rslt . "' + '%'");
                $newNextNo = $next->NextNo;
            }
        } else if ($NoTransactionType == "seqILE") {
            $check = $this->showsingle("select count(*) total
											from ItemLedgerEntry with(nolock)  
											where CustomerCode = '" . $tocustomer . "' 
											And SequenceNo like 'seqILE-' + '" . $NewThB1->rslt . "' + '%' ");
            if ($check->total == 0) {
                $newNextNo = 1;
            } else {
                $next        = $this->showsingle("SELECT 1 + Max(Cast(SUBSTRING (SequenceNo,patindex('%-[0-9]%',SequenceNo) + 1,
											len(SequenceNo)) as Numeric))
											as NextNo 
											from ItemLedgerEntry with(nolock)  
											where CustomerCode = '" . $tocustomer . "' And SequenceNo like 'seqILE-' + '" . $NewThB1->rslt . "' + '%'");
                $newNextNo = $next->NextNo;
            }
        } else {
            $next        = $this->showsingle("SELECT NextNo from NoSerieSetup 
										Where TransactionType = '" . $TransactionType . "' 
										and NoTransactionType = '" . $NoTransactionType . "' + '" . $cstseries . "'
										and CategoryCode = '" . $category . "' and YearNo = Year(getdate()) and MonthNo = Month(getdate())
										and CustomerCode = '" . $tocustomer . "'");
            $newNextNo = $next->NextNo;
        }
        if ($TransactionType == "DOC") {
            $a = $this->showsingle("SELECT '" . $NoTransactionType . "' + '" . $category . "' + '-' + '" . $NewThB1->rslt . "' + '-' + '" . $cstseries . "' + '-' + CAST('" . $newNextNo . "' AS VARCHAR) as Transactions");
        } else if ($TransactionType == "TRANS") {
            $a = $this->showsingle("SELECT '" . $NoTransactionType . "' + '-' + '" . $NewThB1->rslt . "' + '-' + '" . $cstseries . "' + '-'  + CAST('" . $newNextNo . "' AS VARCHAR) as Transactions");
        } else if ($TransactionType == "MASTER") {
            $a = $this->showsingle("SELECT '" . $NoTransactionType . "' + '-' + '" . $NewThB1->rslt . "' + CAST('" . $newNextNo . "' AS VARCHAR) as Transactions ");
        }

        return $a;
    }
}
