<?php

namespace app\rest;

class contactsApi extends api
{
    public $apiName = 'contacts';

    private $tableName = 'contacts';

    private $fields = [
        'source_id',
        'name',
        'phone',
        'email',
        'created_at'
    ];

    /**
     * GET all contacts
     * @return false|string
     * @throws \Exception
     */
    public function indexAction()
    {
        global $db;
        $contacts = [];
        $res = $db->query('select * from ' . $this->tableName . ' order by created_at desc');
        foreach ($res as $row) {
            $date = new \DateTimeImmutable();
            $contacts[] = [
                'id' => $row['id'],
                'source_id' => $row['source_id'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'date' => $date->setTimestamp($row['created_at'])->format('d.m.Y H:i:s'),
            ];
        }
        if (!empty($contacts)) {
            return $this->response($contacts, 200);
        }

        return $this->response('Data not found', 404);
    }

    /**
     * GET search by phone
     * @return false|string
     * @throws \Exception
     */
    public function searchAction()
    {
        global $db;
        $contacts = [];
        $phone = addslashes($this->requestParams['phone']);
        if (empty($phone)) {
            return $this->response('Data not found', 404);
        }
        $res = $db->query(
            'select * from '
            . $this->tableName
            . ' where phone=' . $phone
            . ' order by id desc');
        foreach ($res as $row) {
            $date = new \DateTimeImmutable();
            $contacts[] = [
                'id' => $row['id'],
                'source_id' => $row['source_id'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'date' => $date->setTimestamp($row['created_at'])->format('d.m.Y H:i:s'),
            ];
        }
        if (!empty($contacts)) {
            return $this->response($contacts, 200);
        }

        return $this->response('Data not found', 404);
    }

    /**
     * POST create contacts
     * @return string
     */
    public function createAction()
    {
        $sourceId = $this->requestParams['source_id'];
        $contacts = $this->requestParams['items'];

        $errors = [];
        $added = 0;
        $iter = 0;
        foreach ($this->generatorContacts($contacts) as $contact) {
            $iter++;
            $contactErrors = $this->validateValues($contact, $sourceId);
            if (count($contactErrors)) {
                $errors[$iter] = $contactErrors;
                continue;
            }
            $this->createContact($contact, $sourceId);
            $added++;
        }

        return $this->response(['added' => $added, 'errors' => $errors], 200);

    }

    /**
     * Generator for big arrays
     * @param array $contacts
     * @return \Generator
     */
    public function generatorContacts(array $contacts)
    {
        foreach ($contacts as $key => $contact) {
            yield $contact;
        }
    }

    /**
     * Create contact
     * @param array $contact
     * @param int $sourceId
     */
    private function createContact(array $contact, int $sourceId)
    {
        global $db;

        $values = $this->prepareValue($contact, $sourceId);

        $sql = 'insert into ' . $this->tableName;
        $sql .= ' (' . implode(',', $this->fields) . ')';
        $sql .= ' VALUES (';
        foreach ($this->fields as $field) {
            $sql .= "'" . addslashes($values[$field]) . "', ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $db->query($sql);
    }

    /**
     * Validate value
     * @param array $contact
     * @param int $sourceId
     * @return array
     */
    private function validateValues(array $contact, int $sourceId)
    {
        $errors = [];

        if (empty($contact['phone'])
            || !preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $contact['phone'])
        ) {
            $errors['phone'] = 'Invalid phone number format';
        } else {
            if ($this->checkPhoneTime($contact['phone'], $sourceId)) {
                $errors['phone'] = 'Phone number already exists';
            }
        }

        if (empty($contact['email'])
            || !filter_var($contact['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $errors['email'] = 'Invalid email address format';
        }

        return $errors;
    }

    /**
     * Validate already insert phone
     * @param $phone
     * @param $sourceId
     * @return bool
     */
    private function checkPhoneTime($phone, $sourceId)
    {
        global $db;
        $dateFrom = strtotime(date('Y-m-d H:i:s', strtotime('-1 day')));
        if (strlen(intval($phone)) > 10) {
            $phone = substr(intval($phone), 1);
        } else {
            $phone = intval($phone);
        }

        $sql = 'select count(id) from '
            . $this->tableName
            . ' where phone = ' . $phone
            . ' and source_id = ' . $sourceId
            . ' and created_at BETWEEN ' . $dateFrom . ' AND ' . time();
        $res = $db->query($sql);
        if ($res) {
            foreach ($res as $row) {
                return $row['count(id)'];
            }
        }

        return false;

    }

    /**
     * Prepare fields for insert
     * @param array $values
     * @param int $sourceId
     * @return array
     */
    private function prepareValue(array $values, int $sourceId)
    {
        if (strlen(intval($values['phone'])) > 10) {
            $values['phone'] = substr(intval($values['phone']), 1);
        } else {
            $values['phone'] = intval($values['phone']);
        }

        $values['created_at'] = time();
        $values['source_id'] = $sourceId;

        return $values;
    }
}
