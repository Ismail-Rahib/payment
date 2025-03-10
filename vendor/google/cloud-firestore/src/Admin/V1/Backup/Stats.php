<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/firestore/admin/v1/backup.proto

namespace Google\Cloud\Firestore\Admin\V1\Backup;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Backup specific statistics.
 *
 * Generated from protobuf message <code>google.firestore.admin.v1.Backup.Stats</code>
 */
class Stats extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. Summation of the size of all documents and index entries in
     * the backup, measured in bytes.
     *
     * Generated from protobuf field <code>int64 size_bytes = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $size_bytes = 0;
    /**
     * Output only. The total number of documents contained in the backup.
     *
     * Generated from protobuf field <code>int64 document_count = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $document_count = 0;
    /**
     * Output only. The total number of index entries contained in the backup.
     *
     * Generated from protobuf field <code>int64 index_count = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $index_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $size_bytes
     *           Output only. Summation of the size of all documents and index entries in
     *           the backup, measured in bytes.
     *     @type int|string $document_count
     *           Output only. The total number of documents contained in the backup.
     *     @type int|string $index_count
     *           Output only. The total number of index entries contained in the backup.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Firestore\Admin\V1\Backup::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. Summation of the size of all documents and index entries in
     * the backup, measured in bytes.
     *
     * Generated from protobuf field <code>int64 size_bytes = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getSizeBytes()
    {
        return $this->size_bytes;
    }

    /**
     * Output only. Summation of the size of all documents and index entries in
     * the backup, measured in bytes.
     *
     * Generated from protobuf field <code>int64 size_bytes = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setSizeBytes($var)
    {
        GPBUtil::checkInt64($var);
        $this->size_bytes = $var;

        return $this;
    }

    /**
     * Output only. The total number of documents contained in the backup.
     *
     * Generated from protobuf field <code>int64 document_count = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getDocumentCount()
    {
        return $this->document_count;
    }

    /**
     * Output only. The total number of documents contained in the backup.
     *
     * Generated from protobuf field <code>int64 document_count = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setDocumentCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->document_count = $var;

        return $this;
    }

    /**
     * Output only. The total number of index entries contained in the backup.
     *
     * Generated from protobuf field <code>int64 index_count = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int|string
     */
    public function getIndexCount()
    {
        return $this->index_count;
    }

    /**
     * Output only. The total number of index entries contained in the backup.
     *
     * Generated from protobuf field <code>int64 index_count = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int|string $var
     * @return $this
     */
    public function setIndexCount($var)
    {
        GPBUtil::checkInt64($var);
        $this->index_count = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Stats::class, \Google\Cloud\Firestore\Admin\V1\Backup_Stats::class);

