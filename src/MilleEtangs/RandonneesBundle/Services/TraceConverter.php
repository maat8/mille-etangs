<?php

namespace MilleEtangs\RandonneesBundle\Services;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

use Doctrine\MongoDB\GridFSFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symm\Gisconverter\Gisconverter as Gisconverter;
use MilleEtangs\RandonneesBundle\Document\Trace;

/**
 * @Service("trace_converter")
 */
class TraceConverter
{
    private $dm;

    private $file;
    private $gpx;
    private $kml;

    /**
     * @DI\InjectParams({
     *     "dm" = @DI\Inject("doctrine.odm.mongodb.document_manager")
     * })
     */
    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function getGpx()
    {
        return $this->gpx;
    }

    public function getKml()
    {
        return $this->kml;
    }

    public function generateTracesFromFile(UploadedFile $file)
    {
        $this->file = $file;
        $type = $file->getClientOriginalExtension();

        switch($type) {
            case 'gpx':
                $this->gpx = new Trace();
                $this->gpx->setFile($this->file->getPathName());
                $this->dm->persist($this->gpx);
                // Do not flush here : we could be setting gpx/kml itineary fields
                $this->generateKmlFromGpx();
                break;
            case 'kml':
                break;
            default:
                throw \Exception("Format not supported");
        }
    }

    public function generateKmlFromGpx()
    {
        $kml = Gisconverter::gpxToKml(file_get_contents($this->file));
        if (!empty($kml)) {
            $kml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                        '<kml xmlns="http://www.opengis.net/kml/2.2">
                            <Document>
                            <name></name>
                            <description>c</description>
                            <Style id="blueLine">
                              <LineStyle>
                                <color>ffff0000</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="redLine">
                              <LineStyle>
                                <color>ff0000ff</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="greenLine">
                              <LineStyle>
                                <color>ff009900</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="orangeLine">
                              <LineStyle>
                                <color>ff00ccff</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="pinkLine">
                              <LineStyle>
                                <color>ffff33ff</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="brownLine">
                              <LineStyle>
                                <color>ff66a1cc</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="purpleLine">
                              <LineStyle>
                                <color>ffcc00cc</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Style id="yellowLine">
                              <LineStyle>
                                <color>ff61f2f2</color>
                                <width>4</width>
                              </LineStyle>
                            </Style>
                            <Placemark>
                                <name>Name</name>
                                <description>Description</description>
                                <styleUrl>#blueLine</styleUrl>' .
                        $kml .
                        '   </Placemark>
                        </Document>
                        </kml>';

            $this->kml = new Trace();
            $kml_file = new GridFSFile();
            $kml_file->setBytes($kml);
            $this->kml->setFile($kml_file);
        }
    }

    public function generateGpxFromKml()
    {
        // TODO
    }
}
